<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;
use App\Models\AiPostPrompt;
use App\Models\PlatformAccount;
use App\Models\ImageLibrary;
use App\Models\RepeatScheduled;
use App\Services\InstagramService;
use Carbon\Carbon;
use GuzzleHttp\Client;

class ProcessScheduledInstagramPrompts extends Command
{
    protected $signature = 'instagram:process';
    protected $description = 'Process scheduled prompts and post content to Instagram';

    public function handle()
    {
        $this->info('🔎 Đang kiểm tra các bài viết Instagram đã được lên lịch...');

        // Lấy thời gian hiện tại
        $now = Carbon::now();

        // Log thời gian hiện tại để debug
        $this->info("⏰ Thời gian hiện tại: {$now->toDateTimeString()}");

        // Lấy platform_id của Instagram từ database
        $instagramPlatform = \App\Models\Platform::where('name', 'Instagram')->first();
        if (!$instagramPlatform) {
            $this->error('❌ Không tìm thấy platform Instagram trong database.');
            return;
        }
        $instagramPlatformId = $instagramPlatform->id;

        // Lấy tất cả các prompt có scheduled_at hoặc có lịch trong repeat_scheduled cho Instagram
        $prompts = AiPostPrompt::where('platform_id', $instagramPlatformId)
            ->where(function($query) {
                $query->whereNotNull('scheduled_at')
                    ->orWhereHas('repeatSchedules');
            })
            ->get();

        // Log dữ liệu đầy đủ để kiểm tra
        $this->info('📋 Dữ liệu bảng ai_post_prompts cho Instagram:');
        if ($prompts->isEmpty()) {
            $this->info("⚠️ Không có bản ghi nào trong bảng ai_post_prompts có scheduled_at hoặc repeat_scheduled cho Instagram.");
        } else {
            foreach ($prompts as $prompt) {
                $repeatSchedules = $prompt->repeatSchedules->pluck('schedule')->toArray();
                $this->info("Prompt ID: {$prompt->id}, Status: {$prompt->status}, Scheduled At: " . ($prompt->scheduled_at ? $prompt->scheduled_at->toDateTimeString() : 'null') . ", Repeat Schedules: " . json_encode($repeatSchedules));
            }
        }

        // Đếm các bài viết chưa đến giờ đăng
        $pendingPrompts = $prompts->filter(function ($prompt) use ($now) {
            $scheduledAtCondition = false;
            if ($prompt->scheduled_at) {
                $existingSchedule = RepeatScheduled::where('ai_post_prompts_id', $prompt->id)
                    ->where('schedule', $prompt->scheduled_at)
                    ->first();
                $scheduledAtCondition = !$existingSchedule || !$existingSchedule->instagram_post_id && $now->lessThan($prompt->scheduled_at);
            }
            $repeatSchedulesCondition = false;
            if ($prompt->repeatSchedules->isNotEmpty()) {
                foreach ($prompt->repeatSchedules as $schedule) {
                    if ($schedule->schedule && !$schedule->instagram_post_id && $now->lessThan($schedule->schedule)) {
                        $repeatSchedulesCondition = true;
                        break;
                    }
                }
            }
            return $scheduledAtCondition || $repeatSchedulesCondition;
        });

        $pendingCount = $pendingPrompts->count();
        $pendingIds = $pendingPrompts->pluck('id')->toArray();
        $this->info("📅 Có $pendingCount bài viết Instagram chưa đến giờ đăng. ID: " . ($pendingCount > 0 ? implode(', ', $pendingIds) : 'Không có'));

        foreach ($prompts as $prompt) {
            $shouldProcess = false;
            $isScheduledAt = false;
            $isRepeatSchedule = false;
            $repeatSchedule = null;

            // Tìm thời gian đăng bài tiếp theo
            $nextScheduleTime = null;
            if ($prompt->scheduled_at) {
                $existingSchedule = RepeatScheduled::where('ai_post_prompts_id', $prompt->id)
                    ->where('schedule', $prompt->scheduled_at)
                    ->first();
                if (!$existingSchedule || !$existingSchedule->instagram_post_id) {
                    if (!$nextScheduleTime || $prompt->scheduled_at->lessThan($nextScheduleTime)) {
                        $nextScheduleTime = $prompt->scheduled_at;
                    }
                }
            }
            if ($prompt->repeatSchedules->isNotEmpty()) {
                foreach ($prompt->repeatSchedules as $schedule) {
                    if ($schedule->schedule && !$schedule->instagram_post_id && (!$nextScheduleTime || $schedule->schedule->lessThan($nextScheduleTime))) {
                        $nextScheduleTime = $schedule->schedule;
                    }
                }
            }

            // Ưu tiên kiểm tra scheduled_at (bao gồm đã qua thời gian)
            if ($prompt->scheduled_at) {
                if ($now->greaterThanOrEqualTo($prompt->scheduled_at)) {
                    $existingSchedule = RepeatScheduled::where('ai_post_prompts_id', $prompt->id)
                        ->where('schedule', $prompt->scheduled_at)
                        ->first();

                    if ($existingSchedule && $existingSchedule->instagram_post_id) {
                        $this->info("⏩ Bài viết ID: {$prompt->id} đã được đăng cho scheduled_at (Instagram Post ID: {$existingSchedule->instagram_post_id}). Bỏ qua.");
                    } else {
                        $shouldProcess = true;
                        $isScheduledAt = true;
                        $this->info("📅 Đã đến hoặc qua thời gian đăng bài lần đầu của bài viết ID: {$prompt->id}.");
                    }
                } else {
                    $this->info("⏳ Chưa đến thời gian đăng bài lần đầu của bài viết ID: {$prompt->id}. Thời gian: {$prompt->scheduled_at->toDateTimeString()}");
                }
            }

            // Nếu không có scheduled_at hoặc đã xử lý, kiểm tra repeat_scheduled (bao gồm đã qua thời gian)
            if (!$isScheduledAt && $prompt->repeatSchedules->isNotEmpty()) {
                $hasFutureSchedule = false;
                foreach ($prompt->repeatSchedules as $schedule) {
                    if ($schedule->schedule && $now->greaterThanOrEqualTo($schedule->schedule)) {
                        if ($schedule->instagram_post_id) {
                            $this->info("⏩ Bài viết ID: {$prompt->id} đã được đăng cho lịch chạy lại (Instagram Post ID: {$schedule->instagram_post_id}). Bỏ qua.");
                            continue;
                        }
                        $shouldProcess = true;
                        $isRepeatSchedule = true;
                        $repeatSchedule = $schedule;
                        $this->info("📅 Đã đến hoặc qua thời gian đăng lại của bài viết ID: {$prompt->id}.");
                        break;
                    } elseif ($schedule->schedule && !$schedule->instagram_post_id && $now->lessThan($schedule->schedule)) {
                        $hasFutureSchedule = true;
                    }
                }
                if (!$shouldProcess && $hasFutureSchedule) {
                    $this->info("⏳ Chưa đến thời gian đăng lại của bài viết ID: {$prompt->id}. Thời gian tiếp theo: {$nextScheduleTime->toDateTimeString()}");
                    continue;
                }
            }

            // Nếu đến thời gian hoặc đã qua thời gian, và chưa có instagram_post_id, xử lý prompt
            if ($shouldProcess) {
                $this->info("✏️ Đang xử lý bài viết Instagram ID: {$prompt->id}");

                // Cập nhật trạng thái thành "generating" nếu không phải 'posted'
                if ($prompt->status !== 'posted') {
                    $prompt->update(['status' => 'generating']);
                }

                try {
                    // Kiểm tra sự tồn tại của prompt và image
                    $result = null;
                    if (!empty($prompt->prompt)) {
                        $this->info("📝 Xử lý bài viết với prompt: {$prompt->prompt}");
                        $result = $this->generateContentWithChatGPT($prompt->prompt);
                    } elseif (!empty($prompt->image)) {
                        $this->info("🖼️ Xử lý bài viết với hình ảnh: {$prompt->image}");
                        $result = $this->generateContentFromImageWithChatGPTMini($prompt->image);
                    } else {
                        throw new \Exception('Cả prompt và image đều trống. Không thể tạo nội dung bài đăng.');
                    }

                    // Lưu nội dung vào generated_content, title, và hashtags
                    $prompt->update([
                        'generated_content' => $result['content'],
                        'title' => $result['title'],
                        'hashtags' => $result['hashtags'],
                        'status' => 'generated',
                    ]);

                    // Chuẩn bị dữ liệu để đăng bài
                    $title = $result['title'];
                    $content = $result['content'];
                    $hashtags = $result['hashtags'];

                    // FIXED: Xử lý media từ image_library với error handling tốt hơn
                    $imagePaths = [];
                    $imageNames = [];
                    $videoPaths = [];
                    $videoNames = [];
                    $mediaIds = [];

                    $this->info("🔍 Kiểm tra image_settings: " . json_encode($prompt->image_settings));

                    if (!empty($prompt->image_settings) && is_array($prompt->image_settings)) {
                        foreach ($prompt->image_settings as $index => $setting) {
                            // FIXED: Kiểm tra cấu trúc setting
                            if (!is_array($setting)) {
                                $this->warn("⚠️ Setting tại index {$index} không phải là array: " . json_encode($setting));
                                continue;
                            }

                            $categoryId = $setting['image_category'] ?? null;
                            $count = $setting['image_count'] ?? 0;

                            $this->info("📋 Xử lý setting {$index}: category_id={$categoryId}, count={$count}");

                            if ($categoryId && $count > 0) {
                                // Lấy media chưa sử dụng
                                $records = ImageLibrary::where('category_id', $categoryId)
                                    ->where('status', 'unused')
                                    ->inRandomOrder()
                                    ->take($count)
                                    ->get();

                                $this->info("🔍 Tìm thấy {$records->count()} media trong category {$categoryId}");

                                if ($records->isNotEmpty()) {
                                    foreach ($records as $media) {
                                        $type = $media->type;
                                        $filename = $media->item;
                                        $directory = $type === 'video' ? 'videos' : 'images';

                                        // FIXED: Chuẩn hóa đường dẫn
                                        $relativePath = str_starts_with($filename, "$directory/")
                                            ? $filename
                                            : "$directory/$filename";

                                        $absolutePath = storage_path("app/public/$relativePath");

                                        $this->info("📁 Kiểm tra file: {$absolutePath}");

                                        if (file_exists($absolutePath)) {
                                            // FIXED: Dùng absolute path cho Instagram API
                                            if ($type === 'video') {
                                                $videoPaths[] = $absolutePath;
                                                $videoNames[] = basename($relativePath);
                                            } else {
                                                $imagePaths[] = $absolutePath;
                                                $imageNames[] = basename($relativePath);
                                            }
                                            $mediaIds[] = $media->id;
                                            $this->info("✅ Thêm {$type}: {$absolutePath}");
                                        } else {
                                            $this->warn("⚠️ File không tồn tại: {$absolutePath}");
                                        }
                                    }
                                } else {
                                    $this->warn("⚠️ Không tìm thấy media chưa sử dụng trong image_library với category_id = {$categoryId}");
                                }
                            } else {
                                $this->warn("⚠️ Thiếu image_category hoặc image_count trong image_settings tại index {$index}: " . json_encode($setting));
                            }
                        }

                        $this->info("🖼️ Tổng kết: " . count($imagePaths) . " hình ảnh và " . count($videoPaths) . " video từ image_library (Media IDs: " . implode(', ', $mediaIds) . ").");
                    } else {
                        $this->warn("⚠️ Không có image_settings để lấy media từ image_library.");
                    }

                    // FIXED: Kiểm tra xem có media nào không, nếu không thì báo lỗi
                    if (empty($imagePaths) && empty($videoPaths)) {
                        throw new \Exception('Instagram yêu cầu phải có ít nhất 1 hình ảnh hoặc video. Không tìm thấy media nào từ image_settings.');
                    }

                    // Ghép nội dung hoàn chỉnh để đăng (phù hợp với Instagram)
                    $finalContent = '';
                    if (!empty($title)) {
                        $finalContent .= $title . "\n\n";
                    }
                    if (!empty($content)) {
                        $finalContent .= $content . "\n\n";
                    }

                    $contactInfo = "🌿 THÔNG TIN LIÊN HỆ 🌿\n" .
                        "📍 Tổ 26, ấp Mỹ Ái, xã Mỹ Khánh, huyện Phong Điền, TP Cần Thơ\n" .
                        "📍 Google Map: https://goo.gl/maps/padvdnsZeBHM6UC97\n" .
                        "📞 Hotline: 0901 095 709 | 0931 852 113\n" .
                        "💬 Zalo: 078 2 918 222\n" .
                        "📧 Email: dulichongde@gmail.com\n" .
                        "🌐 Website: www.ongde.vn\n\n";
                    $finalContent .= $contactInfo;

                    // Instagram hashtags
                    $fixedHashtags = "#ongde #dulichongde #khudulichongde #langdulichsinhthaiongde #homestay #phimtruong #mientay #vietnam #thailand #asian #thienvientruclam #chonoicairang #khachsancantho #dulichcantho #langdulichongde";
                    $finalContent .= $fixedHashtags;

                    if (!empty($hashtags) && is_array($hashtags)) {
                        $hashtagsString = implode(' ', $hashtags);
                        $finalContent .= " " . $hashtagsString;
                    }

                    // Đăng nội dung lên Instagram và nhận danh sách bài đăng
                    $postResults = $this->postToInstagram($prompt, $now, $isScheduledAt, $repeatSchedule, $imagePaths, $videoPaths, $mediaIds, $finalContent);

                    // Kiểm tra nếu không đăng được bài
                    if (empty($postResults)) {
                        $this->warn("⚠️ Không đăng được bài lên bất kỳ tài khoản Instagram nào cho prompt ID: {$prompt->id}.");
                        $prompt->update(['status' => 'pending']);
                        continue;
                    }

                    // Cập nhật trạng thái và platform_account_id trong ai_post_prompts
                    $lastPostResult = end($postResults);
                    $prompt->update([
                        'status' => 'posted',
                        'posted_at' => $now,
                        'platform_account_id' => $lastPostResult['platform_account_id'] ?? null,
                    ]);

                    // Log việc cập nhật platform_account_id
                    if ($lastPostResult['platform_account_id']) {
                        $this->info("📝 Đã lưu platform_account_id: {$lastPostResult['platform_account_id']} vào ai_post_prompts cho prompt ID: {$prompt->id}");
                    } else {
                        $this->warn("⚠️ Không có platform_account_id để lưu vào ai_post_prompts cho prompt ID: {$prompt->id}");
                    }

                    // Nếu là scheduled_at, tạo hoặc cập nhật bản ghi trong repeat_scheduled cho mỗi tài khoản
                    if ($isScheduledAt) {
                        foreach ($postResults as $postResult) {
                            $instagramPostId = $postResult['instagram_post_id'];
                            $platformAccountId = $postResult['platform_account_id'];

                            $existingSchedule = RepeatScheduled::where('ai_post_prompts_id', $prompt->id)
                                ->where('schedule', $prompt->scheduled_at)
                                ->where('platform_account_id', $platformAccountId)
                                ->first();

                            if ($existingSchedule) {
                                $existingSchedule->update([
                                    'instagram_post_id' => $instagramPostId,
                                    'platform_account_id' => $platformAccountId,
                                    'reposted_at' => $now,
                                    'title' => $title,
                                    'content' => $finalContent,
                                    'images' => $imageNames,
                                    'videos' => $videoNames,
                                    'media_ids' => $mediaIds,
                                ]);
                                $this->info("📝 Đã cập nhật thông tin bài đăng scheduled_at vào repeat_scheduled cho platform_account_id: {$platformAccountId}");
                            } else {
                                RepeatScheduled::create([
                                    'ai_post_prompts_id' => $prompt->id,
                                    'instagram_post_id' => $instagramPostId,
                                    'platform_account_id' => $platformAccountId,
                                    'reposted_at' => $now,
                                    'schedule' => $prompt->scheduled_at,
                                    'title' => $title,
                                    'content' => $finalContent,
                                    'images' => $imageNames,
                                    'videos' => $videoNames,
                                    'media_ids' => $mediaIds,
                                ]);
                                $this->info("📝 Đã tạo bản ghi mới cho scheduled_at trong repeat_scheduled cho platform_account_id: {$platformAccountId}");
                            }
                        }
                    }

                    // Nếu là repeat_scheduled, cập nhật bản ghi hiện tại cho tài khoản đầu tiên và tạo bản ghi mới cho các tài khoản khác
                    if ($isRepeatSchedule && $repeatSchedule && $repeatSchedule->exists) {
                        $isFirstPlatform = true;
                        foreach ($postResults as $postResult) {
                            $instagramPostId = $postResult['instagram_post_id'];
                            $platformAccountId = $postResult['platform_account_id'];

                            if ($isFirstPlatform) {
                                // Cập nhật trực tiếp bản ghi repeatSchedule hiện tại cho tài khoản đầu tiên
                                $repeatSchedule->update([
                                    'instagram_post_id' => $instagramPostId,
                                    'platform_account_id' => $platformAccountId,
                                    'reposted_at' => $now,
                                    'title' => $title,
                                    'content' => $finalContent,
                                    'images' => $imageNames,
                                    'videos' => $videoNames,
                                    'media_ids' => $mediaIds,
                                ]);
                                $this->info("📝 Đã cập nhật thông tin bài đăng vào repeat_scheduled cho platform_account_id: {$platformAccountId}, schedule: {$repeatSchedule->schedule->toDateTimeString()}");
                                $isFirstPlatform = false;
                            } else {
                                // Tạo bản ghi mới cho các tài khoản khác
                                RepeatScheduled::create([
                                    'ai_post_prompts_id' => $prompt->id,
                                    'instagram_post_id' => $instagramPostId,
                                    'platform_account_id' => $platformAccountId,
                                    'reposted_at' => $now,
                                    'schedule' => $repeatSchedule->schedule,
                                    'title' => $title,
                                    'content' => $finalContent,
                                    'images' => $imageNames,
                                    'videos' => $videoNames,
                                    'media_ids' => $mediaIds,
                                ]);
                                $this->info("📝 Đã tạo bản ghi mới trong repeat_scheduled cho platform_account_id: {$platformAccountId}, schedule: {$repeatSchedule->schedule->toDateTimeString()}");
                            }
                        }
                    } elseif ($isRepeatSchedule && (!$repeatSchedule || !$repeatSchedule->exists)) {
                        $this->error("❌ repeatSchedule không hợp lệ hoặc không tồn tại cho prompt ID: {$prompt->id}");
                        $prompt->update(['status' => 'pending']);
                        continue;
                    }

                    // Hiển thị thời gian đăng bài tiếp theo (nếu còn)
                    $nextScheduleTime = null;
                    if ($prompt->scheduled_at) {
                        $existingSchedule = RepeatScheduled::where('ai_post_prompts_id', $prompt->id)
                            ->where('schedule', $prompt->scheduled_at)
                            ->first();
                        if (!$existingSchedule || !$existingSchedule->instagram_post_id) {
                            if (!$nextScheduleTime || $prompt->scheduled_at->lessThan($nextScheduleTime)) {
                                $nextScheduleTime = $prompt->scheduled_at;
                            }
                        }
                    }
                    if ($prompt->repeatSchedules->isNotEmpty()) {
                        foreach ($prompt->repeatSchedules as $schedule) {
                            if ($schedule->schedule && !$schedule->instagram_post_id && (!$nextScheduleTime || $schedule->schedule->lessThan($nextScheduleTime))) {
                                $nextScheduleTime = $schedule->schedule;
                            }
                        }
                    }
                    if ($nextScheduleTime) {
                        $this->info("⏰ Thời gian đăng bài Instagram tiếp theo của ID: {$prompt->id} là {$nextScheduleTime->toDateTimeString()}");
                    } else {
                        $this->info("ℹ️ Không còn lịch đăng bài Instagram nào chưa được đăng cho ID: {$prompt->id}");
                    }

                    $this->info("✅ Bài viết Instagram ID: {$prompt->id} đã được xử lý và đăng thành công.");
                } catch (\Exception $e) {
                    $this->error("❌ Lỗi khi xử lý bài viết Instagram ID: {$prompt->id} - {$e->getMessage()}");
                    Log::error("Instagram processing error", [
                        'prompt_id' => $prompt->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $prompt->update(['status' => 'pending']);
                }
            }
        }

        $this->info('✅ Đã kiểm tra và xử lý xong tất cả các bài viết Instagram đã lên lịch.');
    }

    /**
     * Gửi prompt đến ChatGPT và nhận nội dung trả về cho Instagram
     */
    protected function generateContentWithChatGPT($prompt)
    {
        $client = new Client();
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            throw new \Exception('❌ API key OpenAI chưa được cấu hình trong file .env');
        }

        try {
            $this->info('🤖 Đang gửi prompt tới ChatGPT cho Instagram...');

            // Thiết lập các tham số cho Instagram
            $platform = 'instagram';
            $maxLength = 2200; // Instagram caption limit
            $maxHashtags = 30; // Instagram allows up to 30 hashtags
            $existingHashtags = [];
            $topic = $prompt;
            $tone = 'thân thiện, thu hút, hoa mỹ, truyền cảm';
            $language = 'Tiếng Việt';

            // Xây dựng hướng dẫn cho hashtags
            $hashtagsInstruction = !empty($existingHashtags)
                ? "Sử dụng các hashtags sau: " . implode(', ', $existingHashtags) . ". Nếu cần, bạn có thể thêm các hashtag khác phù hợp với nội dung, nhưng không vượt quá $maxHashtags hashtag."
                : "Tự động tạo ít nhất 5 hashtag và tối đa $maxHashtags hashtag phù hợp với nội dung bài viết. Đảm bảo mỗi hashtag bắt đầu bằng ký tự # và liên quan đến Làng Du lịch Sinh thái Ông Đề.";

            // Tạo prompt chi tiết cho ChatGPT với yêu cầu phù hợp với Instagram
            $chatGptPrompt = "Bạn là một chuyên gia viết bài quảng cáo Instagram cho Làng Du lịch Sinh thái Ông Đề, một điểm đến nổi tiếng tại Cần Thơ với các dịch vụ homestay, trải nghiệm văn hóa miền Tây, ẩm thực miền Tây, trò chơi dân gian và thiên nhiên xanh mát. Hãy tạo một bài viết cho Instagram với các yêu cầu sau:\n" .
                "- Chủ đề: $topic. Nội dung bài viết phải liên quan trực tiếp đến Làng Du lịch Sinh thái Ông Đề, quảng bá các dịch vụ, trải nghiệm, hoặc sự kiện tại đây (ví dụ: homestay, ẩm thực miền Tây, trò chơi dân gian, cảnh quan thiên nhiên).\n" .
                "- Phong cách: $tone, phù hợp với Instagram\n" .
                "- Ngôn ngữ: $language\n" .
                "- Độ dài tối đa: $maxLength ký tự\n" .
                "- Hashtags: $hashtagsInstruction\n" .
                "- Thêm emoji phù hợp để tăng tính tương tác trên Instagram\n" .
                "- Nội dung phải hấp dẫn và khuyến khích người dùng tương tác (like, comment, share)\n" .
                "Trả về bài viết dưới dạng JSON với các trường: `title` (tiêu đề), `content` (nội dung bài viết), và `hashtags` (danh sách hashtag dưới dạng mảng). Đảm bảo:\n" .
                "- Nội dung bài viết (`content`) không được chứa bất kỳ thẻ HTML nào, chỉ sử dụng văn bản thuần túy.\n" .
                "- Nội dung bài viết (`content`) được ngắt dòng phù hợp cho Instagram. Sử dụng ký tự \\n để ngắt dòng.\n" .
                "- Trường `hashtags` phải là một mảng các chuỗi, mỗi chuỗi bắt đầu bằng ký tự # và liên quan đến Làng Du lịch Sinh thái Ông Đề.\n" .
                "- Chỉ trả về JSON hợp lệ, không thêm bất kỳ nội dung nào khác ngoài JSON.\n" .
                "Ví dụ:\n" .
                "{\n" .
                "  \"title\": \"Khám phá Làng Du lịch Sinh thái Ông Đề\",\n" .
                "  \"content\": \"🌿 Chào mừng bạn đến với Làng Du lịch Sinh thái Ông Đề! \\n\\n😊 Trải nghiệm homestay đậm chất miền Tây trong không gian xanh mát, yên bình. \\n\\n🎉 Đặt chỗ ngay hôm nay để có những kỷ niệm đáng nhớ!\",\n" .
                "  \"hashtags\": [\"#LangDuLichOngDe\", \"#MienTay\", \"#Homestay\", \"#DuLichCanTho\"]\n" .
                "}";

            // Gọi API OpenAI
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Bạn là một trợ lý AI chuyên viết content Instagram cho Làng Du lịch Sinh thái Ông Đề. Chỉ trả về JSON hợp lệ, không thêm bất kỳ văn bản nào khác.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $chatGptPrompt
                        ],
                    ],
                    'max_tokens' => 1500,
                    'temperature' => 0.7,
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            $content = $result['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                throw new \Exception('❌ Không nhận được nội dung trả về từ ChatGPT.');
            }

            // Làm sạch nội dung
            $content = trim($content);
            $content = preg_replace('/^\s+|\s+$/m', '', $content);
            $content = preg_replace('/^```json\s*|\s*```$/s', '', $content);

            // Parse JSON từ nội dung trả về
            $parsedContent = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('❌ Nội dung trả về từ ChatGPT không phải là JSON hợp lệ: ' . $content . ' (Lỗi: ' . json_last_error_msg() . ')');
            }

            // Kiểm tra các trường bắt buộc
            if (!isset($parsedContent['title'], $parsedContent['content'], $parsedContent['hashtags'])) {
                throw new \Exception('❌ JSON trả về từ ChatGPT thiếu các trường bắt buộc (title, content, hashtags): ' . $content);
            }

            // Loại bỏ ký tự Unicode không hợp lệ
            $parsedContent['content'] = preg_replace('/[\x{FFFD}]/u', '', $parsedContent['content']);
            $parsedContent['content'] = trim($parsedContent['content']);

            $this->info('✅ Đã nhận được nội dung từ ChatGPT cho Instagram.');

            return [
                'title' => $parsedContent['title'],
                'content' => $parsedContent['content'],
                'hashtags' => $parsedContent['hashtags'],
            ];
        } catch (\Exception $e) {
            $this->error('❌ Lỗi khi gọi API ChatGPT: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Gửi hình ảnh đến ChatGPT Mini và tạo nội dung bài đăng cho Instagram
     */
    protected function generateContentFromImageWithChatGPTMini($imagePath)
    {
        $client = new Client();
        $apiKey = env('OPENAI_API_KEY');

        if (!$apiKey) {
            throw new \Exception('❌ API key OpenAI chưa được cấu hình trong file .env');
        }

        try {
            $this->info('🤖 Đang gửi hình ảnh tới ChatGPT Mini để phân tích và tạo nội dung cho Instagram...');

            // Đọc và mã hóa hình ảnh thành base64
            $absolutePath = storage_path('app/public/' . $imagePath);
            if (!file_exists($absolutePath)) {
                throw new \Exception("Hình ảnh không tồn tại: {$absolutePath}");
            }

            $imageData = file_get_contents($absolutePath);
            $base64Image = base64_encode($imageData);
            $mimeType = mime_content_type($absolutePath);

            // Thiết lập các tham số cho Instagram
            $platform = 'instagram';
            $maxLength = 2200;
            $maxHashtags = 30;
            $tone = 'thân thiện, thu hút, hoa mỹ, truyền cảm';
            $language = 'Tiếng Việt';

            // Tạo prompt chi tiết cho ChatGPT Mini với yêu cầu phù hợp với Instagram
            $chatGptPrompt = "Bạn là một chuyên gia viết bài quảng cáo Instagram cho Làng Du lịch Sinh thái Ông Đề, một điểm đến nổi tiếng tại Cần Thơ với các dịch vụ homestay, trải nghiệm văn hóa miền Tây, và thiên nhiên xanh mát. Dựa trên hình ảnh được cung cấp, hãy:\n" .
                "1. Phân tích nội dung của hình ảnh (mô tả các yếu tố chính như cảnh vật, đối tượng, màu sắc, cảm xúc, v.v.).\n" .
                "2. Tạo một bài viết Instagram quảng cáo với các yêu cầu sau:\n" .
                "- Nội dung bài viết phải liên quan trực tiếp đến Làng Du lịch Sinh thái Ông Đề, quảng bá các dịch vụ, trải nghiệm, hoặc sự kiện tại đây (ví dụ: homestay, ẩm thực miền Tây, văn hóa địa phương, cảnh quan thiên nhiên).\n" .
                "- Phong cách: $tone, phù hợp với Instagram\n" .
                "- Ngôn ngữ: $language\n" .
                "- Độ dài tối đa: $maxLength ký tự\n" .
                "- Tạo từ 5 đến $maxHashtags hashtag phù hợp với nội dung bài viết. Mỗi hashtag phải bắt đầu bằng ký tự #.\n" .
                "- Thêm emoji phù hợp để tăng tính tương tác trên Instagram\n" .
                "- Nội dung phải hấp dẫn và khuyến khích người dùng tương tác\n" .
                "Trả về bài viết dưới dạng JSON với các trường: `title` (tiêu đề), `content` (nội dung bài viết), và `hashtags` (mảng các hashtag). Đảm bảo:\n" .
                "- Nội dung bài viết (`content`) không chứa thẻ HTML, chỉ là văn bản thuần túy.\n" .
                "- Nội dung bài viết (`content`) được ngắt dòng phù hợp cho Instagram bằng \\n.\n" .
                "- Trường `hashtags` là mảng các chuỗi, mỗi chuỗi bắt đầu bằng # và liên quan đến Làng Du lịch Sinh thái Ông Đề.\n" .
                "- **Chỉ trả về JSON hợp lệ**, không thêm văn bản, ký tự xuống dòng, hoặc markdown.\n" .
                "Ví dụ:\n" .
                "{\n" .
                "  \"title\": \"Khám phá Làng Du lịch Sinh thái Ông Đề\",\n" .
                "  \"content\": \"🌿 Cảnh sắc thiên nhiên tuyệt đẹp tại Ông Đề \\n\\n😊 Trải nghiệm homestay đậm chất miền Tây! \\n\\n🎉 Đặt chỗ ngay hôm nay để có những kỷ niệm đáng nhớ! 😍\",\n" .
                "  \"hashtags\": [\"#LangDuLichOngDe\", \"#MienTay\", \"#Homestay\", \"#DuLichCanTho\"]\n" .
                "}";

            // Gọi API OpenAI với model gpt-4o-mini
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => "Bearer $apiKey",
                    'Content-Type' => 'application/json; charset=utf-8',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Bạn là một trợ lý AI chuyên phân tích hình ảnh và viết content Instagram cho Làng Du lịch Sinh thái Ông Đề. Chỉ trả về JSON hợp lệ với các trường title, content, hashtags. Không thêm bất kỳ văn bản, markdown, hoặc ký tự nào khác.'
                        ],
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $chatGptPrompt
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => "data:{$mimeType};base64,{$base64Image}"
                                    ]
                                ]
                            ]
                        ],
                    ],
                    'max_tokens' => 5000,
                    'temperature' => 0.7,
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            $content = $result['choices'][0]['message']['content'] ?? null;

            if (!$content) {
                throw new \Exception('❌ Không nhận được nội dung trả về từ ChatGPT Mini.');
            }

            // Làm sạch nội dung
            $content = trim($content);
            $content = preg_replace('/^\s+|\s+$/m', '', $content);
            $content = preg_replace('/^```json\s*|\s*```$/s', '', $content);

            // Thử parse JSON
            $parsedContent = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('❌ Nội dung trả về từ ChatGPT Mini không phải là JSON hợp lệ: ' . $content . ' (Lỗi: ' . json_last_error_msg() . ')');
            }

            // Kiểm tra các trường bắt buộc
            if (!isset($parsedContent['title'], $parsedContent['content'])) {
                throw new \Exception('❌ JSON trả về từ ChatGPT Mini thiếu các trường bắt buộc (title, content): ' . $content);
            }

            // Xử lý trường hashtags nếu thiếu
            if (!isset($parsedContent['hashtags']) || !is_array($parsedContent['hashtags'])) {
                $this->warn('⚠️ Trường hashtags không có hoặc không phải mảng. Sử dụng hashtag mặc định...');
                $parsedContent['hashtags'] = ['#LangDuLichOngDe', '#MienTay', '#Homestay', '#DuLichCanTho', '#ThienNhien'];
            }

            // Loại bỏ ký tự Unicode không hợp lệ
            $parsedContent['content'] = preg_replace('/[\x{FFFD}]/u', '', $parsedContent['content']);
            $parsedContent['content'] = trim($parsedContent['content']);

            $this->info('✅ Đã nhận được nội dung từ ChatGPT Mini cho Instagram.');

            return [
                'title' => $parsedContent['title'],
                'content' => $parsedContent['content'],
                'hashtags' => $parsedContent['hashtags'],
            ];
        } catch (\Exception $e) {
            $this->error('❌ Lỗi khi gọi API ChatGPT Mini: ' . $e->getMessage());
            throw $e;
        }
    }

    protected function postToInstagram($prompt, $now, $isScheduledAt, $repeatSchedule, $imagePaths, $videoPaths, $mediaIds = [], $finalContent)
    {
        if (!$prompt->platform_id) {
            throw new \Exception("Platform ID is missing for prompt ID: {$prompt->id}");
        }

        // Lấy các tài khoản Instagram từ platform_accounts dựa trên platform_id và is_active = true
        $query = PlatformAccount::where('platform_id', $prompt->platform_id)
            ->where('is_active', true);

        // Nếu post_option là "selected", chỉ lấy các tài khoản trong selected_pages
        $pageIds = [];
        if ($prompt->post_option === 'selected') {
            if (!empty($prompt->selected_pages) && is_array($prompt->selected_pages)) {
                $pageIds = $prompt->selected_pages;
                $this->info("📋 Danh sách ID tài khoản Instagram được chọn để đăng: " . (empty($pageIds) ? 'Không có' : implode(', ', $pageIds)));
                $query->whereIn('id', $pageIds);
            } else {
                $this->error("❌ Lỗi: Không có tài khoản Instagram nào được chọn để đăng bài (prompt ID: {$prompt->id}). Vui lòng chỉnh sửa và chọn ít nhất một tài khoản.");
                return [];
            }
        } else {
            $this->info("📋 Đăng lên tất cả tài khoản Instagram active của nền tảng ID: {$prompt->platform_id}");
        }

        $platformAccounts = $query->get();

        if ($platformAccounts->isEmpty()) {
            throw new \Exception("No active Instagram accounts found for platform ID: {$prompt->platform_id}");
        }

        // Hiển thị danh sách các tài khoản sẽ đăng
        $accountIds = $platformAccounts->pluck('id')->toArray();
        $accountNames = $platformAccounts->pluck('name')->toArray();
        $this->info("📋 Sẽ đăng lên các tài khoản Instagram có ID: " . implode(', ', $accountIds) . " (Tên: " . implode(', ', $accountNames) . ")");

        $postResults = [];
        $instagramService = app(InstagramService::class);

        foreach ($platformAccounts as $account) {
            if (!$account->access_token) {
                $this->warn("Skipping Instagram account ID: {$account->id} - No valid access token");
                continue;
            }

            if ($account->expires_at && now()->greaterThan($account->expires_at)) {
                $this->warn("Skipping Instagram account ID: {$account->id} - Access token has expired");
                continue;
            }

            if (!$account->page_id) {
                $this->warn("Skipping Instagram account ID: {$account->id} - No Instagram Business Account ID found");
                continue;
            }

            try {
                // Instagram yêu cầu phải có media (hình ảnh hoặc video)
                if (empty($imagePaths) && empty($videoPaths)) {
                    $this->warn("Skipping Instagram account ID: {$account->id} - Instagram requires media (image or video)");
                    continue;
                }

                // Xác định loại media và đường dẫn
                $mediaType = !empty($videoPaths) ? 'video' : 'image';
                $mediaPaths = !empty($videoPaths) ? $videoPaths : $imagePaths;

                $this->info("📱 Đăng bài lên Instagram account {$account->page_id} ({$account->name}) với media type: {$mediaType}");
                $this->info("📁 Media paths: " . implode(', ', $mediaPaths));

                // Đăng bài lên Instagram và lấy instagram_post_id
                $result = $instagramService->postInstagram($account, $finalContent, $mediaPaths, $mediaType);

                if (!$result['success']) {
                    throw new \Exception($result['error']);
                }

                $instagramPostId = $result['post_id'];

                // Nếu là đăng lần đầu, cập nhật trạng thái và used_at trong image_library
                if ($isScheduledAt && !empty($mediaIds)) {
                    ImageLibrary::whereIn('id', $mediaIds)->update([
                        'status' => 'used',
                        'used_at' => $now,
                    ]);
                    $this->info("✅ Đã cập nhật trạng thái thành 'used' và thời gian sử dụng cho " . count($mediaIds) . " media trong image_library cho prompt ID: {$prompt->id}");
                }

                // Lưu kết quả bài đăng
                $postResults[] = [
                    'instagram_post_id' => $instagramPostId,
                    'platform_account_id' => $account->id,
                ];

                $this->info("✅ Đăng bài thành công lên Instagram account {$account->page_id} ({$account->name}) - Post ID: {$instagramPostId}");
            } catch (\Exception $e) {
                $this->error("❌ Lỗi khi đăng bài lên Instagram account {$account->page_id}: " . $e->getMessage());
                Log::error("Instagram posting error", [
                    'account_id' => $account->id,
                    'page_id' => $account->page_id,
                    'error' => $e->getMessage(),
                    'media_paths' => $mediaPaths ?? [],
                ]);
            }
        }

        return $postResults;
    }
}
