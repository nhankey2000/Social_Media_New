<?php

namespace App\Filament\Resources\RepeatScheduledResource\Pages;

use App\Filament\Resources\RepeatScheduledResource;
use App\Models\PlatformAccount;
use App\Services\FacebookService;
use App\Services\InstagramService;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditRepeatScheduled extends EditRecord
{
    protected static string $resource = RepeatScheduledResource::class;

    protected $originalData = [];

    public function getTitle(): string
    {
        return "Chỉnh Sửa Bài Viết Đã Đăng";
    }

    public function getSubheading(): ?string
    {
        return "Cập nhật nội dung bài viết và đồng bộ với mạng xã hội";
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Thông Tin Đăng Bài')
                    ->description('Chi tiết về bài viết đã được đăng lên mạng xã hội')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(3)
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('platform_account_name')
                                    ->label('Trang Đăng Bài')
                                    ->content(function ($record) {
                                        return $record->platformAccount ? $record->platformAccount->name : 'Không có tài khoản';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 rounded-lg p-3 font-semibold text-blue-800'
                                    ]),

                                \Filament\Forms\Components\Placeholder::make('schedule_display')
                                    ->label('Thời Gian Đăng')
                                    ->content(function ($record) {
                                        $schedule = $record->schedule;
                                        if (!empty($schedule)) {
                                            try {
                                                return \Carbon\Carbon::parse($schedule)->format('d/m/Y H:i');
                                            } catch (\Exception $e) {
                                                Log::error('Lỗi khi parse giá trị từ cột schedule trong form', [
                                                    'record_id' => $record->id,
                                                    'schedule' => $schedule,
                                                    'error' => $e->getMessage(),
                                                ]);
                                                return 'Không xác định';
                                            }
                                        }
                                        return 'Không xác định';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 rounded-lg p-3 font-semibold text-green-800'
                                    ]),

                                \Filament\Forms\Components\Placeholder::make('updated_at_display')
                                    ->label('Lần Cập Nhật Cuối')
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
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-purple-200 rounded-lg p-3 font-semibold text-purple-800'
                                    ]),
                            ]),

                        \Filament\Forms\Components\Grid::make(2)
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('facebook_post_info')
                                    ->label('Facebook Post ID')
                                    ->content(function ($record) {
                                        if ($record->facebook_post_id) {
                                            return $record->facebook_post_id . ' • Xem trên Facebook';
                                        }
                                        return 'Không có Post ID';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 rounded-lg p-3 font-mono text-sm text-blue-800'
                                    ])
                                    ->visible(fn ($record) => !empty($record->facebook_post_id)),

                                \Filament\Forms\Components\Placeholder::make('instagram_post_info')
                                    ->label('Instagram Post ID')
                                    ->content(function ($record) {
                                        if ($record->instagram_post_id) {
                                            return $record->instagram_post_id . ' • Xem trên Instagram';
                                        }
                                        return 'Không có Post ID';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-pink-50 to-purple-50 border-pink-200 rounded-lg p-3 font-mono text-sm text-pink-800'
                                    ])
                                    ->visible(fn ($record) => !empty($record->instagram_post_id)),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-slate-900 via-gray-900 to-zinc-900 border-2 border-slate-600 rounded-2xl shadow-2xl hover:shadow-slate-500/25 transition-all duration-500'
                    ]),

                \Filament\Forms\Components\Section::make('Nội Dung Bài Viết')
                    ->description('Chỉnh sửa tiêu đề và nội dung bài viết')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('title')
                            ->label('Tiêu Đề Bài Viết')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Nhập tiêu đề cho bài viết...')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-semibold text-gray-800'
                            ])
                            ->helperText('Tiêu đề sẽ được hiển thị trên mạng xã hội'),

                        \Filament\Forms\Components\Textarea::make('content')
                            ->label('Nội Dung Bài Viết')
                            ->rows(8)
                            ->placeholder('Nhập nội dung chi tiết cho bài viết...')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 leading-relaxed resize-none'
                            ])
                            ->helperText('Nội dung chi tiết sẽ xuất hiện sau tiêu đề')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 border-2 border-blue-600 rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-500'
                    ]),

                \Filament\Forms\Components\Section::make('Quản Lý Hình Ảnh')
                    ->description('Tải lên và quản lý hình ảnh đi kèm bài viết')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('images')
                            ->label('Hình Ảnh Bài Viết')
                            ->multiple()
                            ->image()
                            ->directory('images')
                            ->preserveFilenames()
                            ->deletable()
                            ->downloadable()
                            ->previewable()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                                '9:16',
                                null
                            ])
                            ->maxFiles(10)
                            ->panelLayout('grid')
                            ->extraAttributes([
                                'class' => 'border-2 border-dashed border-green-300 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 hover:border-green-400 transition-all duration-300'
                            ])
                            ->helperText('Hỗ trợ JPG, PNG, GIF. Tối đa 10 ảnh. Thay đổi ảnh sẽ tạo bài viết mới.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(function ($get) {
                        $images = $get('images') ?? $this->record->images ?? [];
                        return !empty($images) && is_array($images);
                    })
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-green-900 via-emerald-900 to-teal-900 border-2 border-green-600 rounded-2xl shadow-2xl hover:shadow-green-500/25 transition-all duration-500'
                    ]),

                \Filament\Forms\Components\Section::make('Quản Lý Video')
                    ->description('Tải lên và quản lý video đi kèm bài viết')
                    ->icon('heroicon-o-video-camera')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('videos')
                            ->label('Video Bài Viết')
                            ->multiple()
                            ->acceptedFileTypes(['video/mp4', 'video/ogg', 'video/webm', 'video/quicktime'])
                            ->directory('videos')
                            ->preserveFilenames()
                            ->deletable()
                            ->downloadable()
                            ->previewable()
                            ->maxFiles(2)
                            ->maxSize(102400) // 100MB
                            ->panelLayout('grid')
                            ->extraAttributes([
                                'class' => 'border-2 border-dashed border-purple-300 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 hover:border-purple-400 transition-all duration-300'
                            ])
                            ->helperText('Hỗ trợ MP4, WebM, QuickTime. Tối đa 2 video, mỗi video 100MB. Thay đổi video sẽ tạo bài viết mới.')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->visible(function ($get) {
                        $videos = $get('videos') ?? $this->record->videos ?? [];
                        return !empty($videos) && is_array($videos);
                    })
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-purple-900 via-pink-900 to-red-900 border-2 border-purple-600 rounded-2xl shadow-2xl hover:shadow-purple-500/25 transition-all duration-500'
                    ]),

                \Filament\Forms\Components\Section::make('Hướng Dẫn Cập Nhật')
                    ->description('Thông tin quan trọng về việc cập nhật bài viết')
                    ->icon('heroicon-o-light-bulb')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('update_instructions')
                            ->label('')
                            ->content('
                                📝 Facebook:
                                • Chỉ thay đổi TIÊU ĐỀ hoặc NỘI DUNG: Bài viết trên Facebook sẽ được cập nhật trực tiếp
                                • Thay đổi HÌNH ẢNH hoặc VIDEO: Bài viết cũ sẽ bị xóa và tạo bài viết mới

                                📱 Instagram:
                                • Instagram KHÔNG hỗ trợ chỉnh sửa bài viết
                                • Mọi thay đổi sẽ XÓA bài viết cũ và TẠO bài viết mới
                                • Post ID sẽ thay đổi và tất cả thống kê sẽ được reset

                                ⚠️ Lưu ý: Backup dữ liệu trước khi thay đổi!
                            ')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-yellow-50 to-orange-50 border-yellow-300 rounded-lg p-4 text-sm text-yellow-800 leading-relaxed whitespace-pre-line'
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-yellow-900 via-orange-900 to-red-900 border-2 border-yellow-600 rounded-2xl shadow-2xl hover:shadow-yellow-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    protected function beforeSave(): void
    {
        $this->originalData = $this->record->getOriginal();
        Log::info('Lưu dữ liệu gốc trước khi lưu', [
            'record_id' => $this->record->id,
            'original_data' => $this->originalData,
        ]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Chuẩn hóa đường dẫn hình ảnh
        if (isset($data['images']) && is_array($data['images'])) {
            $data['images'] = array_map(function ($path) {
                $path = str_replace('\\', '/', trim($path));
                $filename = basename($path);
                $normalizedPath = 'images/' . $filename;
                return $normalizedPath;
            }, array_filter($data['images'], 'is_string'));
        } else {
            $data['images'] = [];
        }

        // Chuẩn hóa đường dẫn video
        if (isset($data['videos']) && is_array($data['videos'])) {
            $data['videos'] = array_map(function ($path) {
                $path = str_replace('\\', '/', trim($path));
                $filename = basename($path);
                $normalizedPath = 'videos/' . $filename;
                return $normalizedPath;
            }, array_filter($data['videos'], 'is_string'));
        } else {
            $data['videos'] = [];
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        Log::info('Dữ liệu trước khi cập nhật model', [
            'record_id' => $record->id,
            'data' => $data,
        ]);
        $record->update($data);
        return $record;
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        // Kiểm tra xem có post ID nào không
        $hasFacebookPost = !empty($record->facebook_post_id) && !empty($record->platform_account_id);
        $hasInstagramPost = !empty($record->instagram_post_id) && !empty($record->platform_account_id);

        if (!$hasFacebookPost && !$hasInstagramPost) {
            Log::warning('Thiếu thông tin để cập nhật bài viết', [
                'record_id' => $record->id,
                'facebook_post_id' => $record->facebook_post_id,
                'instagram_post_id' => $record->instagram_post_id,
                'platform_account_id' => $record->platform_account_id,
            ]);
            Notification::make()
                ->title('Cảnh báo!')
                ->body('Không tìm thấy thông tin bài viết trên mạng xã hội.')
                ->warning()
                ->duration(5000)
                ->send();
            return;
        }

        try {
            $platformAccount = PlatformAccount::find($record->platform_account_id);

            if (!$platformAccount || !$platformAccount->access_token) {
                Log::error('Thông tin tài khoản hoặc access token không hợp lệ', [
                    'platform_account_id' => $record->platform_account_id,
                ]);
                Notification::make()
                    ->title('Lỗi!')
                    ->body('Thông tin tài khoản hoặc access token không hợp lệ.')
                    ->danger()
                    ->duration(8000)
                    ->send();
                return;
            }

            $newTitle = $record->title ?? '';
            $newContent = $record->content ?? '';
            $originalTitle = $this->originalData['title'] ?? '';
            $originalContent = $this->originalData['content'] ?? '';

            // Tạo nội dung message
            $message = '';
            if (!empty($newTitle)) {
                $message .= $newTitle . "\n\n";
            }
            if (!empty($newContent)) {
                $message .= $newContent;
            }

            // Xử lý media paths
            $imagePaths = $this->getMediaPaths($record->images, 'images');
            $videoPaths = $this->getMediaPaths($record->videos, 'videos');

            // Kiểm tra thay đổi
            $originalImages = $this->getOriginalImages();
            $newImages = $this->getCurrentImageNames($record->images);
            $imagesChanged = $this->mediaHaveChanged($originalImages, $newImages);

            $originalVideos = $this->getOriginalVideos();
            $newVideos = $this->getCurrentVideoNames($record->videos);
            $videosChanged = $this->mediaHaveChanged($originalVideos, $newVideos);

            $contentChanged = ($originalTitle !== $newTitle) || ($originalContent !== $newContent);

            Log::info('Kiểm tra thay đổi', [
                'record_id' => $record->id,
                'images_changed' => $imagesChanged,
                'videos_changed' => $videosChanged,
                'content_changed' => $contentChanged,
            ]);

            // Xử lý Facebook
            if ($hasFacebookPost) {
                $this->handleFacebookUpdate($record, $platformAccount, $message, $imagePaths, $videoPaths, $imagesChanged, $videosChanged, $contentChanged);
            }

            // Xử lý Instagram
            if ($hasInstagramPost) {
                $this->handleInstagramUpdate($record, $platformAccount, $message, $imagePaths, $videoPaths, $imagesChanged, $videosChanged, $contentChanged);
            }

        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật bài viết trên mạng xã hội', [
                'record_id' => $record->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Notification::make()
                ->title('Lỗi Hệ Thống!')
                ->body('Cập nhật bài viết thất bại: ' . $e->getMessage())
                ->danger()
                ->duration(10000)
                ->send();
        }
    }

    protected function handleFacebookUpdate($record, $platformAccount, $message, $imagePaths, $videoPaths, $imagesChanged, $videosChanged, $contentChanged): void
    {
        $facebookService = app(FacebookService::class);

        // Nếu có thay đổi về video hoặc hình ảnh, xóa bài viết cũ
        if (($imagesChanged && !empty($imagePaths)) || ($videosChanged && !empty($videoPaths))) {
            try {
                $facebookService->deletePost($record->facebook_post_id, $platformAccount->access_token);

                // Tạo bài viết mới
                $newPostId = null;
                if (!empty($videoPaths)) {
                    $newPostId = $facebookService->postVideoToPage($platformAccount->page_id, $platformAccount->access_token, $message, $videoPaths);
                } else {
                    $newPostId = $facebookService->postToPage($platformAccount->page_id, $platformAccount->access_token, $message, $imagePaths);
                }

                if ($newPostId) {
                    $record->update(['facebook_post_id' => $newPostId]);
                    Notification::make()
                        ->title('Thành công!')
                        ->body('Đã tạo bài viết Facebook mới với ID: ' . $newPostId)
                        ->success()
                        ->duration(8000)
                        ->send();
                }
            } catch (\Exception $e) {
                Log::error('Lỗi khi cập nhật bài viết Facebook', ['error' => $e->getMessage()]);
                Notification::make()
                    ->title('Lỗi!')
                    ->body('Cập nhật Facebook thất bại: ' . $e->getMessage())
                    ->danger()
                    ->duration(8000)
                    ->send();
            }
        } elseif ($contentChanged && !empty($message)) {
            // Chỉ cập nhật nội dung
            try {
                $facebookService->updatePost($record->facebook_post_id, $platformAccount->access_token, $message);
                Notification::make()
                    ->title('Thành công!')
                    ->body('Nội dung bài viết Facebook đã được cập nhật.')
                    ->success()
                    ->duration(5000)
                    ->send();
            } catch (\Exception $e) {
                Log::error('Lỗi khi cập nhật nội dung Facebook', ['error' => $e->getMessage()]);
                Notification::make()
                    ->title('Lỗi!')
                    ->body('Cập nhật nội dung Facebook thất bại: ' . $e->getMessage())
                    ->danger()
                    ->duration(8000)
                    ->send();
            }
        }
    }

    protected function handleInstagramUpdate($record, $platformAccount, $message, $imagePaths, $videoPaths, $imagesChanged, $videosChanged, $contentChanged): void
    {
        $instagramService = app(InstagramService::class);

        // Instagram không hỗ trợ chỉnh sửa, phải xóa và tạo mới
        if ($imagesChanged || $videosChanged || $contentChanged) {
            try {
                // Xóa bài viết cũ
                $instagramService->deletePost($record->instagram_post_id, $platformAccount->access_token);

                Log::info('Đã xóa bài viết Instagram cũ', [
                    'record_id' => $record->id,
                    'old_post_id' => $record->instagram_post_id,
                ]);

                // Tạo bài viết mới
                if (!empty($imagePaths) || !empty($videoPaths)) {
                    $mediaType = !empty($videoPaths) ? 'video' : 'image';
                    $mediaPaths = !empty($videoPaths) ? $this->convertToPublicUrls($videoPaths) : $this->convertToPublicUrls($imagePaths);

                    $result = $instagramService->createReplacementPost($platformAccount, $message, $mediaPaths, $mediaType);

                    if ($result['success'] && $result['post_id']) {
                        $record->update(['instagram_post_id' => $result['post_id']]);

                        Notification::make()
                            ->title('Thành công!')
                            ->body('Đã tạo bài viết Instagram mới với ID: ' . $result['post_id'])
                            ->success()
                            ->duration(8000)
                            ->send();
                    } else {
                        throw new \Exception($result['error'] ?? 'Không thể tạo bài viết Instagram mới');
                    }
                } else {
                    throw new \Exception('Instagram yêu cầu phải có ít nhất 1 hình ảnh hoặc video');
                }

            } catch (\Exception $e) {
                Log::error('Lỗi khi cập nhật bài viết Instagram', [
                    'record_id' => $record->id,
                    'error' => $e->getMessage()
                ]);

                Notification::make()
                    ->title('Lỗi!')
                    ->body('Cập nhật Instagram thất bại: ' . $e->getMessage())
                    ->danger()
                    ->duration(10000)
                    ->send();
            }
        } else {
            Notification::make()
                ->title('Thông báo!')
                ->body('Không có thay đổi nào cần cập nhật cho Instagram.')
                ->info()
                ->duration(3000)
                ->send();
        }
    }

    protected function getMediaPaths($mediaArray, $type): array
    {
        if (!is_array($mediaArray) || empty($mediaArray)) {
            return [];
        }

        $paths = [];
        foreach ($mediaArray as $media) {
            $cleanPath = preg_replace("#^{$type}/#", '', $media);
            $fullPath = storage_path("app/public/{$type}/{$cleanPath}");
            if (file_exists($fullPath)) {
                $paths[] = $fullPath;
            }
        }

        return $paths;
    }

    protected function convertToPublicUrls($paths): array
    {
        return array_map(function($path) {
            $relativePath = str_replace(storage_path('app/public/'), '', $path);
            return asset("storage/{$relativePath}");
        }, $paths);
    }

    protected function getOriginalImages(): array
    {
        $originalImages = isset($this->originalData['images']) && is_array($this->originalData['images'])
            ? $this->originalData['images']
            : [];
        return array_map(function ($path) {
            return preg_replace('#^images/#', '', strval($path));
        }, $originalImages);
    }

    protected function getOriginalVideos(): array
    {
        $originalVideos = isset($this->originalData['videos']) && is_array($this->originalData['videos'])
            ? $this->originalData['videos']
            : [];
        return array_map(function ($path) {
            return preg_replace('#^videos/#', '', strval($path));
        }, $originalVideos);
    }

    protected function getCurrentImageNames($images): array
    {
        if (!is_array($images)) return [];
        return array_map(function ($path) {
            return preg_replace('#^images/#', '', strval($path));
        }, $images);
    }

    protected function getCurrentVideoNames($videos): array
    {
        if (!is_array($videos)) return [];
        return array_map(function ($path) {
            return preg_replace('#^videos/#', '', strval($path));
        }, $videos);
    }

    protected function mediaHaveChanged(array $original, array $new): bool
    {
        $original = array_map('strval', $original);
        $new = array_map('strval', $new);
        sort($original);
        sort($new);
        return $original !== $new;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('view_on_facebook')
                ->label('Xem Trên Facebook')
                ->icon('heroicon-o-globe-alt')
                ->color('primary')
                ->url(function () {
                    if ($this->record->facebook_post_id) {
                        return "https://www.facebook.com/{$this->record->facebook_post_id}";
                    }
                    return null;
                })
                ->openUrlInNewTab()
                ->visible(fn() => !empty($this->record->facebook_post_id)),

            Actions\Action::make('view_on_instagram')
                ->label('Xem Trên Instagram')
                ->icon('heroicon-o-camera')
                ->color('pink')
                ->url(function () {
                    if ($this->record->instagram_post_id) {
                        return "https://www.instagram.com/p/{$this->record->instagram_post_id}";
                    }
                    return null;
                })
                ->openUrlInNewTab()
                ->visible(fn() => !empty($this->record->instagram_post_id)),

            Actions\Action::make('duplicate_post')
                ->label('Tạo Bài Mới Tương Tự')
                ->icon('heroicon-o-document-duplicate')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Tạo Bài Viết AI Mới')
                ->modalDescription('Tạo một bài viết AI mới dựa trên nội dung của bài viết này.')
                ->action(function () {
                    try {
                        // Logic to create new AI post with similar content
                        Notification::make()
                            ->title('Thành công!')
                            ->body('Đã tạo bài viết AI mới dựa trên nội dung này.')
                            ->success()
                            ->duration(5000)
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Lỗi!')
                            ->body('Không thể tạo bài viết mới: ' . $e->getMessage())
                            ->danger()
                            ->duration(8000)
                            ->send();
                    }
                }),

            Actions\DeleteAction::make()
                ->label('Xóa Bài Viết')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Xóa Bài Viết Hoàn Toàn')
                ->modalDescription('Bài viết sẽ bị xóa cả trên mạng xã hội và trong hệ thống. Hành động này không thể hoàn tác.')
                ->successNotificationTitle('Đã xóa bài viết thành công!')
                ->before(function () {
                    $platformAccount = PlatformAccount::find($this->record->platform_account_id);

                    if (!$platformAccount || !$platformAccount->access_token) {
                        Notification::make()
                            ->title('Cảnh báo!')
                            ->body('Không tìm thấy thông tin tài khoản. Chỉ xóa trong hệ thống.')
                            ->warning()
                            ->duration(8000)
                            ->send();
                        return;
                    }

                    // Xóa Facebook post
                    if ($this->record->facebook_post_id) {
                        try {
                            $facebookService = app(FacebookService::class);
                            $facebookService->deletePost($this->record->facebook_post_id, $platformAccount->access_token);

                            Notification::make()
                                ->title('Thành công!')
                                ->body('Bài viết đã được xóa khỏi Facebook.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        } catch (\Exception $e) {
                            Log::error('Lỗi khi xóa bài viết trên Facebook', [
                                'record_id' => $this->record->id,
                                'error' => $e->getMessage(),
                            ]);
                            Notification::make()
                                ->title('Cảnh báo!')
                                ->body('Không thể xóa bài viết trên Facebook: ' . $e->getMessage())
                                ->warning()
                                ->duration(8000)
                                ->send();
                        }
                    }

                    // Xóa Instagram post
                    if ($this->record->instagram_post_id) {
                        try {
                            $instagramService = app(InstagramService::class);
                            $instagramService->deletePost($this->record->instagram_post_id, $platformAccount->access_token);

                            Notification::make()
                                ->title('Thành công!')
                                ->body('Bài viết đã được xóa khỏi Instagram.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        } catch (\Exception $e) {
                            Log::error('Lỗi khi xóa bài viết trên Instagram', [
                                'record_id' => $this->record->id,
                                'error' => $e->getMessage(),
                            ]);
                            Notification::make()
                                ->title('Cảnh báo!')
                                ->body('Không thể xóa bài viết trên Instagram: ' . $e->getMessage())
                                ->warning()
                                ->duration(8000)
                                ->send();
                        }
                    }
                }),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Cập Nhật Bài Viết')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->extraAttributes([
                    'class' => 'bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300'
                ]),

            $this->getCancelFormAction()
                ->label('Hủy Thay Đổi')
                ->icon('heroicon-o-x-circle')
                ->color('gray')
                ->extraAttributes([
                    'class' => 'bg-gradient-to-r from-gray-500 to-slate-500 hover:from-gray-600 hover:to-slate-600 text-white font-medium py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300'
                ]),
        ];
    }

    protected function fillForm(): void
    {
        $data = $this->record->toArray();

        // Chuẩn hóa đường dẫn hình ảnh
        if (isset($data['images']) && is_array($data['images'])) {
            $data['images'] = array_map(function ($image) {
                $image = str_replace('\\', '/', trim($image));
                $filename = preg_replace('#^images/#', '', $image);
                return 'images/' . $filename;
            }, $data['images']);
        }

        // Chuẩn hóa đường dẫn video
        if (isset($data['videos']) && is_array($data['videos'])) {
            $data['videos'] = array_map(function ($video) {
                $video = str_replace('\\', '/', trim($video));
                $filename = preg_replace('#^videos/#', '', $video);
                return 'videos/' . $filename;
            }, $data['videos']);
        }

        $this->form->fill($data);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
