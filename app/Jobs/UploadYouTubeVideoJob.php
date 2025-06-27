<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\YouTubeVideo;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadYouTubeVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 1800; // 30 phút timeout cho video lớn
    public $tries = 3; // Thử lại tối đa 3 lần

    /**
     * Create a new job instance.
     */
    public function __construct(
        public YouTubeVideo $video
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Starting YouTube upload job', [
                'video_id' => $this->video->id,
                'title' => $this->video->title,
                'video_type' => $this->video->video_type ?? 'long'
            ]);

            // Cập nhật trạng thái đang upload
            $this->video->update(['upload_status' => 'uploading']);

            $platformAccount = $this->video->platformAccount;
            if (!$platformAccount) {
                throw new \Exception('Không tìm thấy kênh YouTube.');
            }

            // Kiểm tra file video
            if (!$this->video->video_file || !Storage::disk('local')->exists($this->video->video_file)) {
                throw new \Exception('File video không tồn tại.');
            }

            $client = new Google_Client();
            $client->setAccessToken(json_decode($platformAccount->access_token, true));

            // Kiểm tra và refresh token nếu hết hạn
            if ($client->isAccessTokenExpired()) {
                $facebookAccount = DB::table('facebook_accounts')
                    ->where('platform_id', 3)
                    ->first();

                if (!$facebookAccount) {
                    throw new \Exception('Không tìm thấy thông tin ứng dụng YouTube.');
                }

                $client->setClientId($facebookAccount->app_id);
                $client->setClientSecret($facebookAccount->app_secret);
                $client->setRedirectUri($facebookAccount->redirect_url);
                $client->refreshToken($client->getRefreshToken());

                $newToken = $client->getAccessToken();
                $platformAccount->update(['access_token' => json_encode($newToken)]);
            }

            $youtube = new Google_Service_YouTube($client);

            // ========== TẠO VIDEO OBJECT VỚI XỬ LÝ SHORTS ==========
            $videoObj = new \Google_Service_YouTube_Video();
            $snippet = new \Google_Service_YouTube_VideoSnippet();

            // ========== XỬ LÝ TITLE CHO SHORTS ==========
            if ($this->video->video_type === 'short') {
                $title = $this->video->title;
                if (!str_contains(strtolower($title), '#shorts') && !str_contains(strtolower($title), 'shorts')) {
                    $title = $title . ' #Shorts';
                }
                $snippet->setTitle($title);

                Log::info('Setting Shorts title', ['original' => $this->video->title, 'new' => $title]);
            } else {
                $snippet->setTitle($this->video->title);
            }

            // ========== XỬ LÝ DESCRIPTION CHO SHORTS ==========
            if ($this->video->video_type === 'short') {
                // Tạo description tối ưu cho Shorts
                $description = "#Shorts #YouTubeShorts\n\n" . $this->video->description;

                // Thêm hashtags phổ biến cho Shorts
                $shortsTags = [
                    '#Viral', '#Trending', '#QuickVideo', '#ShortVideo',
                    '#Entertainment', '#Fun', '#Amazing', '#MustWatch'
                ];

                // Random chọn 2-3 hashtags để tránh spam
                $selectedTags = array_rand(array_flip($shortsTags), min(3, count($shortsTags)));
                if (is_string($selectedTags)) $selectedTags = [$selectedTags];

                $description .= "\n\n" . implode(' ', $selectedTags);

                $snippet->setDescription($description);

                Log::info('Setting Shorts description', ['description' => substr($description, 0, 100) . '...']);
            } else {
                $snippet->setDescription($this->video->description);
            }

            // ========== CATEGORY VÀ TAGS CHO SHORTS ==========
            if ($this->video->video_type === 'short') {
                // Force Entertainment category cho Shorts
                $snippet->setCategoryId('24');

                // Tags tối ưu cho Shorts
                $tags = [
                    'Shorts',
                    'YouTubeShorts',
                    'Short',
                    'Viral',
                    'Trending',
                    'QuickVideo',
                    'ShortForm',
                    'Mobile'
                ];

                // Thêm tags từ title và description
                $content = strtolower($this->video->title . ' ' . $this->video->description);

                // Detect content type và thêm tags phù hợp
                if (str_contains($content, 'funny') || str_contains($content, 'hài') || str_contains($content, 'comedy')) {
                    $tags[] = 'Comedy';
                    $tags[] = 'Funny';
                }

                if (str_contains($content, 'music') || str_contains($content, 'nhạc') || str_contains($content, 'song')) {
                    $tags[] = 'Music';
                    $tags[] = 'Song';
                }

                if (str_contains($content, 'dance') || str_contains($content, 'nhảy')) {
                    $tags[] = 'Dance';
                    $tags[] = 'Dancing';
                }

                if (str_contains($content, 'food') || str_contains($content, 'ăn') || str_contains($content, 'cooking')) {
                    $tags[] = 'Food';
                    $tags[] = 'Cooking';
                }

                if (str_contains($content, 'game') || str_contains($content, 'gaming')) {
                    $tags[] = 'Gaming';
                    $tags[] = 'Game';
                }

                // Extract hashtags từ description
                preg_match_all('/#(\w+)/', $this->video->description, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $tag) {
                        if (!in_array($tag, $tags) && count($tags) < 15) {
                            $tags[] = ucfirst(strtolower($tag));
                        }
                    }
                }

                // Giới hạn 15 tags (YouTube limit)
                $tags = array_unique(array_slice($tags, 0, 15));
                $snippet->setTags($tags);

                Log::info('Setting Shorts tags', ['tags' => $tags]);

            } else {
                // Video dài thông thường
                $snippet->setCategoryId($this->video->category_id);

                // Tags cho video dài
                preg_match_all('/#(\w+)/', $this->video->description, $matches);
                if (!empty($matches[1])) {
                    $tags = array_slice($matches[1], 0, 10);
                    $snippet->setTags($tags);
                }
            }

            $videoObj->setSnippet($snippet);

            // ========== STATUS CHO SHORTS ==========
            $status = new \Google_Service_YouTube_VideoStatus();
            $status->setPrivacyStatus($this->video->status);

            // Thêm các thuộc tính quan trọng cho Shorts
            if ($this->video->video_type === 'short') {
                Log::info('Configuring video for Shorts format', [
                    'video_id' => $this->video->id,
                    'title_has_shorts' => str_contains(strtolower($snippet->getTitle()), 'shorts'),
                    'category' => $snippet->getCategoryId()
                ]);
            }

            $videoObj->setStatus($status);

            // Upload file
            $videoPath = Storage::disk('local')->path($this->video->video_file);

            // ========== KIỂM TRA FILE CHO SHORTS ==========
            if ($this->video->video_type === 'short') {
                // Kiểm tra thời lượng video (nên <= 60 giây)
                $fileSize = filesize($videoPath);
                $fileSizeMB = $fileSize / (1024 * 1024);

                if ($fileSizeMB > 50) { // Video quá lớn có thể > 60s
                    Log::warning('Shorts file may be too long', [
                        'file_size_mb' => $fileSizeMB,
                        'video_id' => $this->video->id
                    ]);
                }

                Log::info('Uploading Shorts video', [
                    'file_size_mb' => $fileSizeMB,
                    'video_id' => $this->video->id
                ]);
            }

            $chunkSizeBytes = 1 * 1024 * 1024; // 1MB

            Log::info('Starting video upload to YouTube', [
                'video_id' => $this->video->id,
                'file_size' => filesize($videoPath),
                'video_type' => $this->video->video_type ?? 'long'
            ]);

            $client->setDefer(true);
            $insertRequest = $youtube->videos->insert('snippet,status', $videoObj);

            $media = new \Google_Http_MediaFileUpload(
                $client,
                $insertRequest,
                'video/*',
                null,
                true,
                $chunkSizeBytes
            );
            $media->setFileSize(filesize($videoPath));

            $uploadStatus = false;
            $handle = fopen($videoPath, 'rb');
            while (!$uploadStatus && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $uploadStatus = $media->nextChunk($chunk);
            }
            fclose($handle);

            $client->setDefer(false);

            // Cập nhật thông tin video sau khi upload thành công
            $this->video->update([
                'video_id' => $uploadStatus['id'],
                'upload_status' => 'uploaded',
                'uploaded_at' => now(),
                'upload_error' => null
            ]);

            // Xóa file sau khi upload thành công
            Storage::disk('local')->delete($this->video->video_file);

            $videoType = $this->video->video_type === 'short' ? 'YouTube Shorts' : 'Video dài';
            Log::info("$videoType uploaded successfully via job", [
                'video_id' => $this->video->id,
                'youtube_id' => $uploadStatus['id'],
                'title' => $this->video->title,
                'video_type' => $this->video->video_type ?? 'long'
            ]);

        } catch (\Exception $e) {
            // Cập nhật trạng thái lỗi
            $this->video->update([
                'upload_status' => 'failed',
                'upload_error' => $e->getMessage()
            ]);

            Log::error('YouTube upload job failed', [
                'video_id' => $this->video->id,
                'title' => $this->video->title,
                'video_type' => $this->video->video_type ?? 'long',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Ném lại exception để job biết là failed
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('YouTube upload job failed permanently', [
            'video_id' => $this->video->id,
            'title' => $this->video->title,
            'video_type' => $this->video->video_type ?? 'long',
            'error' => $exception->getMessage()
        ]);

        $this->video->update([
            'upload_status' => 'failed',
            'upload_error' => 'Job failed after ' . $this->tries . ' attempts: ' . $exception->getMessage()
        ]);
    }
}
