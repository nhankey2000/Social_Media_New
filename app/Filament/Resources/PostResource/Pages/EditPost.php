<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\PlatformAccount;
use App\Models\Post;
use App\Models\PostRepost;
use App\Services\FacebookService;
use App\Services\InstagramService; // THÊM INSTAGRAM SERVICE
use Illuminate\Support\Facades\Log;
use Filament\Actions\DeleteAction;
use Filament\Forms\Form;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    public function form(Form $form): Form
    {
        $isPublished = $this->record->status === 'published';

        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Thông tin đăng bài')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(3)
                            ->schema([
                                // Tài khoản đăng bài
                                $isPublished
                                    ? \Filament\Forms\Components\Placeholder::make('platform_account_display')
                                    ->label('Tài khoản đăng bài')
                                    ->content(function ($record) {
                                        $platformAccount = PlatformAccount::find($record->platform_account_id);
                                        return $platformAccount ? $platformAccount->name : 'Không xác định';
                                    })
                                    : \Filament\Forms\Components\Select::make('platform_account_id')
                                    ->label('Tài khoản đăng bài')
                                    ->options(PlatformAccount::all()->pluck('name', 'id'))
                                    ->required()
                                    ->default($this->record->platform_account_id),

                                // Thời gian đăng
                                \Filament\Forms\Components\Placeholder::make('schedule_display')
                                    ->label('Thời gian đăng')
                                    ->content(function ($record) {
                                        $schedule = $record->scheduled_at;
                                        if (!empty($schedule)) {
                                            try {
                                                return \Carbon\Carbon::parse($schedule)->format('d/m/Y H:i');
                                            } catch (\Exception $e) {
                                                Log::error('Lỗi khi parse giá trị từ cột scheduled_at trong form', [
                                                    'record_id' => $record->id,
                                                    'scheduled_at' => $schedule,
                                                    'error' => $e->getMessage(),
                                                ]);
                                                return 'Không xác định';
                                            }
                                        }
                                        return 'Không xác định';
                                    }),

                                // Thời gian cập nhật
                                \Filament\Forms\Components\Placeholder::make('updated_at_display')
                                    ->label('Thời gian cập nhật')
                                    ->content(function ($record) {
                                        $updatedAt = $record->updated_at;
                                        if (!empty($updatedAt)) {
                                            try {
                                                return \Carbon\Carbon::parse($updatedAt)->format('d/m/Y H:i');
                                            } catch (\Exception $e) {
                                                Log::error('Lỗi khi parse giá trị từ cột updated_at trong form', [
                                                    'record_id' => $record->id,
                                                    'updated_at' => $updatedAt,
                                                    'error' => $e->getMessage(),
                                                ]);
                                                return 'Không xác định';
                                            }
                                        }
                                        return 'Không xác định';
                                    }),
                            ]),
                    ])
                    ->collapsible(),
                \Filament\Forms\Components\Section::make('Nội dung bài viết')
                    ->schema(array_filter([
                        // Tiêu đề
                        $isPublished
                            ? \Filament\Forms\Components\Placeholder::make('title_display')
                            ->label('Tiêu đề')
                            ->content(fn ($record) => $record->title)
                            : \Filament\Forms\Components\TextInput::make('title')
                            ->label('Tiêu đề')
                            ->required()
                            ->maxLength(255),

                        // Nội dung
                        $isPublished
                            ? \Filament\Forms\Components\Placeholder::make('content_display')
                            ->label('Nội dung')
                            ->content(fn ($record) => $record->content)
                            : \Filament\Forms\Components\Textarea::make('content')
                            ->label('Nội dung')
                            ->rows(6)
                            ->columnSpanFull(),

                        // Hashtags
                        $isPublished
                            ? \Filament\Forms\Components\Placeholder::make('hashtags_display')
                            ->label('Hashtags')
                            ->content(fn ($record) => !empty($record->hashtags) ? implode(' ', $record->hashtags) : 'Không có hashtags')
                            : \Filament\Forms\Components\TagsInput::make('hashtags')
                            ->label('Hashtags')
                            ->separator(' ')
                            ->columnSpanFull(),

                        // Lịch đăng (chỉ hiển thị nếu chưa đăng)
                        !$isPublished
                            ? \Filament\Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('Lịch đăng')
                            ->required()
                            ->default(now())
                            ->minDate(now())
                            : null,
                    ], fn ($item) => !is_null($item)))
                    ->collapsible()
                    ->columns(1),

                // Hình ảnh
                \Filament\Forms\Components\Section::make('Hình ảnh')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('images')
                            ->label('Hình ảnh')
                            ->multiple()
                            ->image()
                            ->directory('post-media')
                            ->preserveFilenames()
                            ->downloadable()
                            ->previewable()
                            ->columnSpanFull()
                            ->disabled($isPublished)
                            ->deletable(!$isPublished)
                            ->default(fn ($record) => $record->media),
                    ])
                    ->collapsible()
                    ->visible(function ($get) use ($isPublished) {
                        if ($isPublished) {
                            $images = $this->record->media ?? [];
                            Log::info('Kiểm tra hiển thị section Hình ảnh khi đã đăng', [
                                'images' => $images,
                                'is_visible' => !empty($images) && is_array($images),
                            ]);
                            return !empty($images) && is_array($images);
                        }

                        $images = $get('images') ?? [];
                        Log::info('Kiểm tra hiển thị section Hình ảnh khi chưa đăng', [
                            'images' => $images,
                            'is_visible' => !empty($images) && is_array($images),
                        ]);
                        return !empty($images) && is_array($images);
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Xoá')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->successNotificationTitle('Bài viết đã được xóa thành công')
                // THÊM XỬ LÝ XÓA INSTAGRAM TRONG DELETE ACTION
                ->before(function (Post $record) {
                    $this->deletePostFromPlatforms($record);
                }),
        ];
    }

    protected function getFormActions(): array
    {
        $isPublished = $this->record->status === 'published';

        return $isPublished
            ? [
                $this->getSaveFormAction()
                    ->label('Lưu')
                    ->icon('heroicon-o-check'),
                $this->getCancelFormAction()
                    ->label('Đóng')
                    ->icon('heroicon-o-x-mark'),
            ]
            : [
                $this->getSaveFormAction()
                    ->label('Lưu')
                    ->icon('heroicon-o-check'),
                $this->getCancelFormAction()
                    ->label('Huỷ')
                    ->icon('heroicon-o-x-mark'),
            ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        Log::info('Dữ liệu ban đầu trong mutateFormDataBeforeFill', [
            'record_id' => $this->record->id,
            'data' => $data,
            'record_media' => $this->record->media,
        ]);

        $data['images'] = $data['media'] ?? $this->record->media ?? [];

        Log::info('Dữ liệu sau khi gán trong mutateFormDataBeforeFill', [
            'record_id' => $this->record->id,
            'images' => $data['images'],
        ]);

        $data['reposts'] = $this->record->reposts->map(function ($repost) {
            return [
                'platform_account_ids' => [$repost->platform_account_id],
                'reposted_at' => $repost->reposted_at,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['media'] = $data['images'] ?? [];

        $this->platformAccountIds = [$data['platform_account_id']];
        $this->reposts = $data['reposts'] ?? [];

        if (empty($this->platformAccountIds)) {
            throw new \Exception('Phải chọn ít nhất một tài khoản nền tảng.');
        }

        Log::info('Dữ liệu trong mutateFormDataBeforeSave', [
            'record_id' => $this->record->id,
            'media' => $data['media'],
            'platform_account_ids' => $this->platformAccountIds,
        ]);

        unset($data['platform_account_id']);
        unset($data['reposts']);
        unset($data['images']);
        unset($data['platform_account_ids']);
        unset($data['platform_id']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->update(['platform_account_id' => $this->platformAccountIds[0]]);

        $this->record->reposts()->delete();
        if (!empty($this->reposts)) {
            foreach ($this->reposts as $repost) {
                if (in_array($this->record->platform_account_id, $repost['platform_account_ids'])) {
                    PostRepost::create([
                        'post_id' => $this->record->id,
                        'platform_account_id' => $this->record->platform_account_id,
                        'reposted_at' => $repost['reposted_at'],
                    ]);
                }
            }

            Log::info('Lịch đăng lại đã được cập nhật:', $this->reposts);
        }

        $this->updateOnPlatform();
    }

    // CẬP NHẬT PHƯƠNG THỨC updateOnPlatform ĐỂ HỖ TRỢ INSTAGRAM
    protected function updateOnPlatform(): void
    {
        $facebookService = app(FacebookService::class);
        $instagramService = app(InstagramService::class);

        $platformAccount = $this->record->platformAccount;

        if (!$platformAccount) {
            Log::warning('Không tìm thấy platform account cho post ID: ' . $this->record->id);
            return;
        }

        $platformName = $platformAccount->platform->name;

        // XỬ LÝ FACEBOOK
        if ($platformName === 'Facebook') {
            $title = $this->record->title ?: '';
            $content = $this->record->content ?: '';

            // Tạo tiêu đề in đậm cho Facebook
            $boldTitle = $this->toBoldUnicode($title);
            $message = $boldTitle . "\n\n" . $content;

            if ($this->record->hashtags) {
                $message .= "\n" . implode(' ', $this->record->hashtags);
            }

            if ($this->record->facebook_post_id && $platformAccount->access_token) {
                try {
                    $facebookService->updatePost($this->record->facebook_post_id, $platformAccount->access_token, $message);
                    Log::info("✅ Đã cập nhật bài viết Facebook: Post ID {$this->record->facebook_post_id}");
                } catch (\Exception $e) {
                    Log::error('❌ Cập nhật Facebook post thất bại: ' . $e->getMessage());
                }
            }
        }

        // XỬ LÝ INSTAGRAM
        if ($platformName === 'Instagram') {
            $title = $this->record->title ?: '';
            $content = $this->record->content ?: '';
            $message = $title . "\n\n" . $content;

            if ($this->record->hashtags) {
                $message .= "\n" . implode(' ', $this->record->hashtags);
            }

            if ($this->record->instagram_post_id && $platformAccount->access_token) {
                try {
                    // Tạo media URLs từ media paths
                    $mediaUrls = [];
                    if ($this->record->media) {
                        foreach ($this->record->media as $mediaPath) {
                            $mediaUrls[] = asset('storage/' . $mediaPath);
                        }
                    }

                    // Lấy media cũ để so sánh (giả sử từ DB hoặc cache)
                    $oldMediaUrls = []; // Có thể lấy từ một field khác hoặc cache

                    $mediaType = 'image'; // Mặc định là image, có thể detect từ extension

                    $editResult = $instagramService->editInstagramPost(
                        $platformAccount,
                        $this->record->instagram_post_id,
                        $message,
                        $mediaUrls,
                        $mediaType,
                        $oldMediaUrls
                    );

                    if ($editResult['success']) {
                        if ($editResult['action'] === 'recreated') {
                            // Cập nhật post ID mới nếu bài viết được tạo lại
                            $this->record->update(['instagram_post_id' => $editResult['new_post_id']]);
                            Log::info("✅ Instagram post đã được tạo lại: Old ID {$this->record->instagram_post_id} -> New ID {$editResult['new_post_id']}");
                        } else {
                            Log::info("✅ Đã cập nhật Instagram post: Post ID {$this->record->instagram_post_id}");
                        }
                    } else {
                        Log::error('❌ Cập nhật Instagram post thất bại: ' . $editResult['error']);
                    }
                } catch (\Exception $e) {
                    Log::error('❌ Cập nhật Instagram post thất bại: ' . $e->getMessage());
                }
            }
        }

        // XỬ LÝ REPOSTS
        foreach ($this->record->reposts as $repost) {
            $repostPlatformAccount = PlatformAccount::find($repost->platform_account_id);
            if (!$repostPlatformAccount) {
                continue;
            }

            $repostPlatformName = $repostPlatformAccount->platform->name;

            if ($repostPlatformName === 'Facebook' && $repost->facebook_post_id) {
                if ($repostPlatformAccount->access_token) {
                    try {
                        $title = $this->record->title ?: '';
                        $content = $this->record->content ?: '';
                        $boldTitle = $this->toBoldUnicode($title);
                        $message = $boldTitle . "\n\n" . $content;

                        if ($this->record->hashtags) {
                            $message .= "\n" . implode(' ', $this->record->hashtags);
                        }

                        $facebookService->updatePost($repost->facebook_post_id, $repostPlatformAccount->access_token, $message);
                        Log::info("✅ Đã cập nhật Facebook repost: Post ID {$repost->facebook_post_id}");
                    } catch (\Exception $e) {
                        Log::error('❌ Cập nhật Facebook repost thất bại: ' . $e->getMessage());
                    }
                }
            }

            if ($repostPlatformName === 'Instagram' && $repost->instagram_post_id) {
                if ($repostPlatformAccount->access_token) {
                    try {
                        $title = $this->record->title ?: '';
                        $content = $this->record->content ?: '';
                        $message = $title . "\n\n" . $content;

                        if ($this->record->hashtags) {
                            $message .= "\n" . implode(' ', $this->record->hashtags);
                        }

                        // Tạo media URLs từ media paths
                        $mediaUrls = [];
                        if ($this->record->media) {
                            foreach ($this->record->media as $mediaPath) {
                                $mediaUrls[] = asset('storage/' . $mediaPath);
                            }
                        }

                        $editResult = $instagramService->editInstagramPost(
                            $repostPlatformAccount,
                            $repost->instagram_post_id,
                            $message,
                            $mediaUrls,
                            'image',
                            []
                        );

                        if ($editResult['success']) {
                            if ($editResult['action'] === 'recreated') {
                                // Cập nhật post ID mới cho repost
                                $repost->update(['instagram_post_id' => $editResult['new_post_id']]);
                                Log::info("✅ Instagram repost đã được tạo lại: Old ID {$repost->instagram_post_id} -> New ID {$editResult['new_post_id']}");
                            } else {
                                Log::info("✅ Đã cập nhật Instagram repost: Post ID {$repost->instagram_post_id}");
                            }
                        } else {
                            Log::error('❌ Cập nhật Instagram repost thất bại: ' . $editResult['error']);
                        }
                    } catch (\Exception $e) {
                        Log::error('❌ Cập nhật Instagram repost thất bại: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    // THÊM PHƯƠNG THỨC XÓA POST TỪ PLATFORMS
    protected function deletePostFromPlatforms(Post $record): void
    {
        $facebookService = app(FacebookService::class);
        $instagramService = app(InstagramService::class);

        $platformAccount = $record->platformAccount;

        if ($platformAccount) {
            $platformName = $platformAccount->platform->name;

            // Xóa từ Facebook nếu có
            if ($platformName === 'Facebook' && $record->facebook_post_id && $platformAccount->access_token) {
                try {
                    $facebookService->deletePost($record->facebook_post_id, $platformAccount->access_token);
                    Log::info('✅ EditPost: Đã xóa Facebook post thành công: ' . $record->facebook_post_id);
                } catch (\Exception $e) {
                    Log::error('❌ EditPost: Xóa Facebook post thất bại: ' . $e->getMessage());
                }
            }

            // Xóa từ Instagram nếu có
            if ($platformName === 'Instagram' && $record->instagram_post_id && $platformAccount->access_token) {
                try {
                    $deleteResult = $instagramService->deleteInstagramPost($platformAccount, $record->instagram_post_id);
                    if ($deleteResult['success']) {
                        Log::info('✅ EditPost: Đã xóa Instagram post thành công: ' . $record->instagram_post_id);
                    } else {
                        Log::warning('⚠️ EditPost: Xóa Instagram post thất bại: ' . ($deleteResult['error'] ?? 'Unknown error'));
                    }
                } catch (\Exception $e) {
                    Log::error('❌ EditPost: Xóa Instagram post thất bại: ' . $e->getMessage());
                }
            }
        }

        // Xóa reposts
        foreach ($record->reposts as $repost) {
            $repostPlatformAccount = PlatformAccount::find($repost->platform_account_id);
            if ($repostPlatformAccount) {
                $repostPlatformName = $repostPlatformAccount->platform->name;

                if ($repostPlatformName === 'Facebook' && $repost->facebook_post_id && $repostPlatformAccount->access_token) {
                    try {
                        $facebookService->deletePost($repost->facebook_post_id, $repostPlatformAccount->access_token);
                        Log::info('✅ EditPost: Đã xóa Facebook repost thành công: ' . $repost->facebook_post_id);
                    } catch (\Exception $e) {
                        Log::error('❌ EditPost: Xóa Facebook repost thất bại: ' . $e->getMessage());
                    }
                }

                if ($repostPlatformName === 'Instagram' && $repost->instagram_post_id && $repostPlatformAccount->access_token) {
                    try {
                        $deleteResult = $instagramService->deleteInstagramPost($repostPlatformAccount, $repost->instagram_post_id);
                        if ($deleteResult['success']) {
                            Log::info('✅ EditPost: Đã xóa Instagram repost thành công: ' . $repost->instagram_post_id);
                        } else {
                            Log::warning('⚠️ EditPost: Xóa Instagram repost thất bại: ' . ($deleteResult['error'] ?? 'Unknown error'));
                        }
                    } catch (\Exception $e) {
                        Log::error('❌ EditPost: Xóa Instagram repost thất bại: ' . $e->getMessage());
                    }
                }
            }
        }
    }

    // THÊM HELPER METHOD ĐỂ TẠO CHỮ IN ĐẬM
    private function toBoldUnicode(string $text): string
    {
        $boldMap = [
            'A' => '𝐀', 'B' => '𝐁', 'C' => '𝐂', 'D' => '𝐃', 'E' => '𝐄', 'F' => '𝐅', 'G' => '𝐆', 'H' => '𝐇',
            'I' => '𝐈', 'J' => '𝐉', 'K' => '𝐊', 'L' => '𝐋', 'M' => '𝐌', 'N' => '𝐍', 'O' => '𝐎', 'P' => '𝐏',
            'Q' => '𝐐', 'R' => '𝐑', 'S' => '𝐒', 'T' => '𝐓', 'U' => '𝐔', 'V' => '𝐕', 'W' => '𝐖', 'X' => '𝐗',
            'Y' => '𝐘', 'Z' => '𝐙', 'a' => '𝐚', 'b' => '𝐛', 'c' => '𝐜', 'd' => '𝐝', 'e' => '𝐞', 'f' => '𝐟',
            'g' => '𝐠', 'h' => '𝐡', 'i' => '𝐢', 'j' => '𝐣', 'k' => '𝐤', 'l' => '𝐥', 'm' => '𝐦', 'n' => '𝐧',
            'o' => '𝐨', 'p' => '𝐩', 'q' => '𝐪', 'r' => '𝐫', 's' => '𝐬', 't' => '𝐭', 'u' => '𝐮', 'v' => '𝐯',
            'w' => '𝐰', 'x' => '𝐱', 'y' => '𝐲', 'z' => '𝐳', '0' => '𝟎', '1' => '𝟏', '2' => '𝟐', '3' => '𝟑',
            '4' => '𝟒', '5' => '𝟓', '6' => '𝟔', '7' => '𝟕', '8' => '𝟖', '9' => '𝟗',
        ];

        $boldText = '';
        foreach (mb_str_split($text) as $char) {
            $boldText .= $boldMap[$char] ?? $char;
        }

        return $boldText;
    }

    protected ?array $platformAccountIds = [];
    protected ?array $reposts = [];
}
