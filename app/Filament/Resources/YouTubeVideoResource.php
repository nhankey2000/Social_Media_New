<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YouTubeVideoResource\Pages;
use App\Models\YouTubeVideo;
use App\Models\PlatformAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class YouTubeVideoResource extends Resource
{
    protected static ?string $model = YouTubeVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Video YouTube';

    protected static ?string $pluralLabel = 'Video YouTube';

    protected static ?string $navigationGroup = 'Quản Lý Nội Dung';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông Tin Video YouTube')
                    ->description('Cung cấp thông tin và file video để đăng lên YouTube')
                    ->icon('heroicon-o-video-camera')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('platform_account_id')
                                    ->label('Kênh YouTube')
                                    ->required()
                                    ->options(
                                        PlatformAccount::where('platform_id', 3)->pluck('name', 'id')
                                    )
                                    ->searchable()
                                    ->preload()
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100'
                                    ])
                                    ->helperText('Chọn kênh YouTube để đăng video'),

                                Forms\Components\TextInput::make('title')
                                    ->label('Tiêu Đề Video')
                                    ->required()
                                    ->maxLength(100)
                                    ->placeholder('Nhập tiêu đề video...')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100'
                                    ])
                                    ->helperText('Tiêu đề tối đa 100 ký tự'),
                            ]),

                        Forms\Components\Textarea::make('description')
                            ->label('Mô Tả Video')
                            ->required()
                            ->rows(4)
                            ->maxLength(5000)
                            ->placeholder('Nhập mô tả cho video...')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-br from-green-50 to-teal-50 border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 text-sm resize-none'
                            ])
                            ->helperText('Mô tả tối đa 5000 ký tự')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Danh Mục Video')
                                    ->options([
                                        '1' => 'Film & Animation',
                                        '2' => 'Autos & Vehicles',
                                        '10' => 'Music',
                                        '15' => 'Pets & Animals',
                                        '17' => 'Sports',
                                        '19' => 'Travel & Events',
                                        '20' => 'Gaming',
                                        '22' => 'People & Blogs',
                                        '23' => 'Comedy',
                                        '24' => 'Entertainment',
                                        '25' => 'News & Politics',
                                        '26' => 'Howto & Style',
                                        '27' => 'Education',
                                        '28' => 'Science & Technology',
                                        '29' => 'Nonprofits & Activism',
                                    ])
                                    ->required()
                                    ->default('22')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl focus:border-yellow-500 focus:ring-4 focus:ring-yellow-100'
                                    ])
                                    ->helperText('Chọn danh mục phù hợp cho video'),

                                Forms\Components\Select::make('status')
                                    ->label('Trạng Thái Video')
                                    ->options([
                                        'public' => 'Công khai',
                                        'private' => 'Riêng tư',
                                        'unlisted' => 'Không công khai',
                                    ])
                                    ->required()
                                    ->default('public')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-300 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100'
                                    ])
                                    ->helperText('Chọn trạng thái hiển thị của video'),
                            ]),

                        // ========== THÊM FIELD LOẠI VIDEO ==========
                        Forms\Components\Select::make('video_type')
                            ->label('Loại Video')
                            ->options([
                                'long' => '📹 Video Dài (Thông thường)',
                                'short' => '⚡ YouTube Shorts (Tối đa 60 giây)',
                            ])
                            ->required()
                            ->default('long')
                            ->live()
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-indigo-50 to-blue-50 border-2 border-indigo-300 rounded-xl focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100'
                            ])
                            ->helperText('YouTube Shorts: Video dọc, tối đa 60 giây, hiển thị trong tab Shorts')
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state === 'short') {
                                    $set('category_id', '24'); // Entertainment cho Shorts
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('video_file')
                            ->label('File Video')
                            ->required()
                            ->acceptedFileTypes(['video/mp4', 'video/mpeg', 'video/webm'])
                            ->maxSize(1024000) // 1GB
                            ->disk('local')
                            ->directory('youtube-videos')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-teal-50 to-cyan-50 border-2 border-teal-300 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100'
                            ])
                            ->helperText(function ($get) {
                                $videoType = $get('video_type');
                                if ($videoType === 'short') {
                                    return '📱 YouTube Shorts: Video dọc (9:16), tối đa 60 giây, định dạng MP4 khuyến nghị';
                                }
                                return '🎬 Video dài: MP4, MPEG hoặc WebM, tối đa 1GB';
                            })
                            ->columnSpanFull(),

                        Forms\Components\DateTimePicker::make('scheduled_at')
                            ->label('Lịch Đăng Video')
                            ->placeholder('Chọn thời gian đăng video...')
                            ->seconds(false)
                            ->minDate(now()->addMinutes(1))
                            ->maxDate(now()->addYear())
                            ->displayFormat('d/m/Y H:i')
                            ->format('Y-m-d H:i:s')
                            ->timezone('Asia/Ho_Chi_Minh')
                            ->native(false)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-emerald-50 to-teal-50 border-2 border-emerald-300 rounded-xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100'
                            ])
                            ->helperText('Để trống nếu muốn đăng ngay lập tức. Chọn thời gian ít nhất 1 phút sau hiện tại.')
                            ->columnSpanFull()
                            ->live()
                            ->afterStateUpdated(function ($state, $set) {
                                if ($state && $state <= now()) {
                                    $set('scheduled_at', null);
                                }
                            }),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 border-2 border-blue-600 rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platformAccount.name')
                    ->label('Tên Kênh')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-video-camera'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu Đề Video')
                    ->sortable()
                    ->searchable()
                    ->limit(25)
                    ->badge()
                    ->color('secondary'),

                // ========== THÊM CỘT LOẠI VIDEO ==========
                Tables\Columns\TextColumn::make('video_type')
                    ->label('Loại')
                    ->badge()
                    ->color(fn($record) => $record->video_type_color ?? 'gray')
                    ->icon(fn($record) => $record->video_type_icon ?? 'heroicon-o-video-camera')
                    ->formatStateUsing(fn($record) => $record->video_type_text ?? 'N/A')
                    ->sortable(),

                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Lịch Đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->scheduled_at) return 'gray';
                        if ($record->scheduled_at > now()) return 'warning';
                        if ($record->isUploaded()) return 'success';
                        return 'info';
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if (!$state) return 'Đăng ngay';
                        if ($record->isUploaded()) return $state->format('d/m/Y H:i') . ' ✓';
                        if ($state > now()) return $state->format('d/m/Y H:i') . ' ⏰';
                        return $state->format('d/m/Y H:i') . ' ⏳';
                    })
                    ->tooltip(function ($record) {
                        if (!$record->scheduled_at) return 'Video sẽ được đăng ngay lập tức';
                        if ($record->isUploaded()) return 'Đã đăng thành công';
                        if ($record->scheduled_at > now()) return 'Đang chờ đến giờ đăng';
                        return 'Sẵn sàng để đăng';
                    }),

                Tables\Columns\TextColumn::make('upload_status_text')
                    ->label('Trạng Thái Upload')
                    ->badge()
                    ->color(fn($record) => $record->upload_status_color ?? 'gray')
                    ->icon(function ($record) {
                        return match($record->upload_status ?? 'pending') {
                            'pending' => 'heroicon-o-clock',
                            'uploading' => 'heroicon-o-arrow-up',
                            'uploaded' => 'heroicon-o-check-circle',
                            'failed' => 'heroicon-o-x-circle',
                            default => 'heroicon-o-question-mark-circle',
                        };
                    }),

                Tables\Columns\TextColumn::make('video_id')
                    ->label('Video ID')
                    ->searchable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép Video ID!')
                    ->badge()
                    ->color('info')
                    ->url(fn($record) => $record->video_id ? "https://www.youtube.com/watch?v={$record->video_id}" : null)
                    ->openUrlInNewTab()
                    ->placeholder('Chưa đăng')
                    ->limit(12),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('platform_account_id')
                    ->label('Lọc theo kênh')
                    ->relationship('platformAccount', 'name')
                    ->multiple()
                    ->preload(),

                // ========== THÊM FILTER LOẠI VIDEO ==========
                Tables\Filters\SelectFilter::make('video_type')
                    ->label('Lọc theo loại video')
                    ->options([
                        'long' => 'Video Dài',
                        'short' => 'YouTube Shorts',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options([
                        'public' => 'Công khai',
                        'private' => 'Riêng tư',
                        'unlisted' => 'Không công khai',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('upload_status')
                    ->label('Lọc theo trạng thái upload')
                    ->options([
                        'pending' => 'Chờ đăng',
                        'uploading' => 'Đang đăng',
                        'uploaded' => 'Đã đăng',
                        'failed' => 'Lỗi',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('scheduled_today')
                    ->label('Lên lịch hôm nay')
                    ->query(fn($query) => $query->whereDate('scheduled_at', today())),

                Tables\Filters\Filter::make('ready_to_upload')
                    ->label('Sẵn sàng đăng')
                    ->query(fn($query) => $query->where('upload_status', 'pending')
                        ->whereNotNull('scheduled_at')
                        ->where('scheduled_at', '<=', now())
                        ->whereNull('video_id')),

                Tables\Filters\Filter::make('has_video_file')
                    ->label('Có file video')
                    ->query(fn($query) => $query->whereNotNull('video_file')),

                Tables\Filters\Filter::make('uploaded')
                    ->label('Đã đăng lên YouTube')
                    ->query(fn($query) => $query->whereNotNull('video_id')),

                Tables\Filters\Filter::make('shorts_only')
                    ->label('Chỉ YouTube Shorts')
                    ->query(fn($query) => $query->where('video_type', 'short')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('upload_now')
                        ->label('Đăng Ngay')
                        ->icon('heroicon-o-bolt')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Đăng Video Ngay Lập Tức')
                        ->modalDescription('Video sẽ được đăng ngay lên YouTube, bỏ qua lịch đã đặt.')
                        ->modalSubmitActionLabel('Đăng Ngay')
                        ->action(function (YouTubeVideo $record) {
                            if (!$record->video_file || !Storage::disk('local')->exists($record->video_file)) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không tìm thấy file video.')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            try {
                                $platformAccount = $record->platformAccount;
                                if (!$platformAccount) {
                                    throw new \Exception('Không tìm thấy kênh YouTube.');
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

                                $video = new \Google_Service_YouTube_Video();
                                $snippet = new \Google_Service_YouTube_VideoSnippet();
                                $snippet->setTitle($record->title);

                                // ========== XỬ LÝ RIÊNG CHO SHORTS ==========
                                if ($record->video_type === 'short') {
                                    // Thêm #Shorts vào đầu description
                                    $description = $record->description;
                                    if (!str_contains(strtolower($description), '#shorts')) {
                                        $description = "#Shorts\n\n" . $description;
                                    }
                                    $snippet->setDescription($description);

                                    // Force category Entertainment cho Shorts
                                    $snippet->setCategoryId('24');

                                    // Tags tối ưu cho Shorts
                                    $tags = $record->getAutoTags();
                                    $snippet->setTags(array_slice($tags, 0, 10));
                                } else {
                                    // Video dài thông thường
                                    $snippet->setDescription($record->description);
                                    $snippet->setCategoryId($record->category_id);

                                    // Tags thông thường
                                    preg_match_all('/#(\w+)/', $record->description, $matches);
                                    if (!empty($matches[1])) {
                                        $tags = array_slice($matches[1], 0, 10);
                                        $snippet->setTags($tags);
                                    }
                                }

                                $video->setSnippet($snippet);

                                $status = new \Google_Service_YouTube_VideoStatus();
                                $status->setPrivacyStatus($record->status);
                                $video->setStatus($status);

                                $videoPath = Storage::disk('local')->path($record->video_file);
                                $chunkSizeBytes = 1 * 1024 * 1024; // 1MB

                                $client->setDefer(true);
                                $insertRequest = $youtube->videos->insert('snippet,status', $video);

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
                                $record->update([
                                    'video_id' => $uploadStatus['id'],
                                    'upload_status' => 'uploaded',
                                    'uploaded_at' => now(),
                                    'upload_error' => null
                                ]);

                                $videoTypeText = $record->video_type === 'short' ? 'YouTube Shorts' : 'Video dài';
                                Notification::make()
                                    ->title('Thành Công!')
                                    ->body("{$videoTypeText} đã được đăng lên YouTube thành công.")
                                    ->success()
                                    ->duration(8000)
                                    ->send();

                                // Xóa file sau khi upload
                                Storage::disk('local')->delete($record->video_file);
                            } catch (\Exception $e) {
                                $record->update([
                                    'upload_status' => 'failed',
                                    'upload_error' => $e->getMessage()
                                ]);

                                Notification::make()
                                    ->title('Lỗi Khi Đăng Video!')
                                    ->body('Không thể đăng video: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(10000)
                                    ->send();
                            }
                        })
                        ->visible(fn(YouTubeVideo $record) => $record->isPending() && $record->video_file),

                    Tables\Actions\Action::make('cancel_schedule')
                        ->label('Hủy Lịch')
                        ->icon('heroicon-o-x-mark')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Hủy Lịch Đăng Video')
                        ->modalDescription('Video sẽ không được tự động đăng theo lịch đã đặt.')
                        ->modalSubmitActionLabel('Hủy Lịch')
                        ->action(function (YouTubeVideo $record) {
                            $record->update([
                                'scheduled_at' => null,
                                'upload_status' => 'pending'
                            ]);

                            Notification::make()
                                ->title('Đã Hủy Lịch!')
                                ->body('Lịch đăng video đã được hủy.')
                                ->success()
                                ->send();
                        })
                        ->visible(fn(YouTubeVideo $record) => !is_null($record->scheduled_at) && $record->isPending()),

                    Tables\Actions\Action::make('retry_upload')
                        ->label('Thử Lại')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->requiresConfirmation()
                        ->modalHeading('Thử Lại Upload Video')
                        ->modalDescription('Video sẽ được thử upload lại lên YouTube.')
                        ->modalSubmitActionLabel('Thử Lại')
                        ->action(function (YouTubeVideo $record) {
                            if (!$record->video_file || !Storage::disk('local')->exists($record->video_file)) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không tìm thấy file video.')
                                    ->danger()
                                    ->send();
                                return;
                            }

                            // Reset trạng thái và thử lại
                            $record->update([
                                'upload_status' => 'pending',
                                'upload_error' => null
                            ]);

                            Notification::make()
                                ->title('Đã Reset!')
                                ->body('Trạng thái đã được reset về pending. Bạn có thể thử đăng lại.')
                                ->success()
                                ->send();
                        })
                        ->visible(fn(YouTubeVideo $record) => ($record->upload_status ?? 'pending') === 'failed'),

                    Tables\Actions\ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth('6xl'),

                    Tables\Actions\EditAction::make()
                        ->label('Chỉnh Sửa')
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning'),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa Video')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Video')
                        ->modalDescription('Bạn có chắc chắn muốn xóa video này? Hành động này chỉ xóa bản ghi trong hệ thống, không xóa video trên YouTube.')
                        ->modalSubmitActionLabel('Xóa Video')
                        ->action(function (YouTubeVideo $record) {
                            try {
                                // Xóa file video nếu chưa được đăng lên YouTube
                                if (!is_null($record->video_file) && Storage::disk('local')->exists($record->video_file)) {
                                    Storage::disk('local')->delete($record->video_file);
                                }

                                $record->delete();

                                Notification::make()
                                    ->title('Thành Công!')
                                    ->body('Video đã được xóa khỏi hệ thống.')
                                    ->success()
                                    ->duration(5000)
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không thể xóa video: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(8000)
                                    ->send();
                            }
                        }),
                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Xóa Các Video Đã Chọn')
                    ->modalHeading('Xóa Các Video')
                    ->modalSubheading('Bạn có chắc chắn muốn xóa các video này? Hành động này chỉ xóa bản ghi trong hệ thống, không xóa video trên YouTube.')
                    ->modalButton('Xác Nhận Xóa')
                    ->color('danger')
                    ->action(function ($records) {
                        try {
                            $count = 0;
                            foreach ($records as $record) {
                                // Xóa file video nếu chưa được đăng
                                if (!is_null($record->video_file) && Storage::disk('local')->exists($record->video_file)) {
                                    Storage::disk('local')->delete($record->video_file);
                                }
                                $record->delete();
                                $count++;
                            }

                            Notification::make()
                                ->title('Thành Công!')
                                ->body("Đã xóa {$count} video khỏi hệ thống.")
                                ->success()
                                ->duration(5000)
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Lỗi!')
                                ->body('Không thể xóa video: ' . $e->getMessage())
                                ->danger()
                                ->duration(8000)
                                ->send();
                        }
                    }),
            ])
            ->emptyStateHeading('Chưa có video YouTube nào')
            ->emptyStateDescription('Hãy thêm video mới để bắt đầu đăng lên YouTube!')
            ->emptyStateIcon('heroicon-o-video-camera')
            ->striped()
            ->recordUrl(null)
            ->poll('300s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Thông Tin Video')
                    ->icon('heroicon-o-video-camera')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('platformAccount.name')
                                    ->label('Kênh YouTube')
                                    ->badge()
                                    ->color('primary')
                                    ->icon('heroicon-o-video-camera'),

                                Infolists\Components\TextEntry::make('title')
                                    ->label('Tiêu Đề Video')
                                    ->copyable()
                                    ->copyMessage('Đã sao chép tiêu đề!')
                                    ->badge()
                                    ->color('secondary'),

                                // ========== HIỂN THỊ LOẠI VIDEO ==========
                                Infolists\Components\TextEntry::make('video_type')
                                    ->label('Loại Video')
                                    ->badge()
                                    ->color(fn($record) => $record->video_type_color ?? 'gray')
                                    ->icon(fn($record) => $record->video_type_icon ?? 'heroicon-o-video-camera')
                                    ->formatStateUsing(fn($record) => $record->video_type_text ?? 'N/A'),

                                Infolists\Components\TextEntry::make('scheduled_at')
                                    ->label('Lịch Đăng')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->badge()
                                    ->color(function ($record) {
                                        if (!$record->scheduled_at) return 'gray';
                                        if ($record->scheduled_at > now()) return 'warning';
                                        if ($record->isUploaded()) return 'success';
                                        return 'info';
                                    })
                                    ->formatStateUsing(function ($state, $record) {
                                        if (!$state) return 'Đăng ngay';
                                        return $state->format('d/m/Y H:i:s');
                                    }),

                                Infolists\Components\TextEntry::make('upload_status_text')
                                    ->label('Trạng Thái Upload')
                                    ->badge()
                                    ->color(fn($record) => $record->upload_status_color ?? 'gray'),

                                Infolists\Components\TextEntry::make('status')
                                    ->label('Trạng Thái')
                                    ->badge()
                                    ->color(fn($state) => match ($state) {
                                        'public' => 'success',
                                        'private' => 'warning',
                                        'unlisted' => 'gray',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn($state) => match ($state) {
                                        'public' => 'Công khai',
                                        'private' => 'Riêng tư',
                                        'unlisted' => 'Không công khai',
                                        default => $state,
                                    }),

                                Infolists\Components\TextEntry::make('category_id')
                                    ->label('Danh Mục')
                                    ->formatStateUsing(fn($state) => match ($state) {
                                        '1' => 'Film & Animation',
                                        '2' => 'Autos & Vehicles',
                                        '10' => 'Music',
                                        '15' => 'Pets & Animals',
                                        '17' => 'Sports',
                                        '19' => 'Travel & Events',
                                        '20' => 'Gaming',
                                        '22' => 'People & Blogs',
                                        '23' => 'Comedy',
                                        '24' => 'Entertainment',
                                        '25' => 'News & Politics',
                                        '26' => 'Howto & Style',
                                        '27' => 'Education',
                                        '28' => 'Science & Technology',
                                        '29' => 'Nonprofits & Activism',
                                        default => $state,
                                    })
                                    ->badge()
                                    ->color('info'),

                                Infolists\Components\TextEntry::make('video_id')
                                    ->label('Video ID')
                                    ->copyable()
                                    ->copyMessage('Đã sao chép Video ID!')
                                    ->fontFamily('mono')
                                    ->badge()
                                    ->color('info')
                                    ->url(fn($record) => $record->video_id ? "https://www.youtube.com/watch?v={$record->video_id}" : null)
                                    ->openUrlInNewTab()
                                    ->placeholder('Chưa đăng lên YouTube'),

                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Ngày Tạo')
                                    ->dateTime('d/m/Y H:i:s')
                                    ->badge()
                                    ->color('gray'),
                            ]),

                        Infolists\Components\TextEntry::make('description')
                            ->label('Mô Tả Video')
                            ->markdown()
                            ->columnSpanFull(),

                        // ========== HIỂN THỊ THÔNG TIN SHORTS ==========
                        Infolists\Components\TextEntry::make('video_recommendations')
                            ->label('Khuyến Nghị')
                            ->state(function ($record) {
                                if ($record->video_type === 'short') {
                                    return "📱 Định dạng: Video dọc (9:16), MP4 khuyến nghị\n⏱️ Thời lượng: Tối đa 60 giây\n🏷️ Tags: " . implode(', ', $record->getAutoTags());
                                }
                                return "🎬 Định dạng: Video ngang (16:9), MP4/WebM\n⏱️ Thời lượng: Không giới hạn";
                            })
                            ->badge()
                            ->color(fn($record) => $record->video_type === 'short' ? 'warning' : 'info')
                            ->visible(fn($record) => $record->video_type)
                            ->columnSpanFull(),

                        Infolists\Components\TextEntry::make('upload_error')
                            ->label('Lỗi Upload')
                            ->color('danger')
                            ->badge()
                            ->visible(fn($record) => !empty($record->upload_error))
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('File Video')
                    ->icon('heroicon-o-film')
                    ->schema([
                        Infolists\Components\TextEntry::make('video_file')
                            ->label('Tên File')
                            ->formatStateUsing(fn($state) => $state ? basename($state) : 'Không có file')
                            ->badge()
                            ->color(fn($state) => $state ? 'success' : 'gray')
                            ->icon(fn($state) => $state ? 'heroicon-o-document-text' : 'heroicon-o-x-circle'),

                        Infolists\Components\TextEntry::make('file_info')
                            ->label('Kích Thước File')
                            ->state(function ($record) {
                                if (!$record->video_file) {
                                    return 'Không có file';
                                }

                                if (Storage::disk('local')->exists($record->video_file)) {
                                    $size = Storage::disk('local')->size($record->video_file);
                                    return number_format($size / (1024 * 1024), 2) . ' MB';
                                }

                                return 'File không tồn tại';
                            })
                            ->badge()
                            ->color(function ($record) {
                                if (!$record->video_file) return 'gray';
                                return Storage::disk('local')->exists($record->video_file) ? 'info' : 'danger';
                            })
                            ->icon('heroicon-o-server'),

                        Infolists\Components\TextEntry::make('video_player')
                            ->label('Video Preview')
                            ->html()
                            ->state(function ($record) {
                                if (!$record->video_file || !Storage::disk('local')->exists($record->video_file)) {
                                    return '<div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-8 text-center border-2 border-dashed border-gray-300 dark:border-gray-600">
                                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-2">Không có video</h3>
                                        <p class="text-gray-500 dark:text-gray-400">File video không tồn tại hoặc đã bị xóa.</p>
                                    </div>';
                                }

                                $filename = basename($record->video_file);
                                $videoUrl = url('/storage/youtube-videos/' . $filename);
                                $videoTypeClass = $record->video_type === 'short' ? 'max-width: 400px; max-height: 700px;' : 'max-height: 500px;';
                                $videoTypeLabel = $record->video_type === 'short' ? '⚡ YouTube Shorts' : '🎬 Video Dài';

                                return '<div class="bg-gray-900 rounded-xl overflow-hidden shadow-2xl border border-gray-700">
                                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-4 py-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <h3 class="text-white font-semibold">' . htmlspecialchars($record->title) . '</h3>
                                            </div>
                                            <span class="text-white text-sm font-medium">' . $videoTypeLabel . '</span>
                                        </div>
                                    </div>

                                    <div class="p-4">
                                        <video
                                            controls
                                            preload="metadata"
                                            class="w-full h-auto rounded-lg shadow-lg bg-black mx-auto"
                                            style="' . $videoTypeClass . '"
                                            controlsList="nodownload"
                                        >
                                            <source src="' . $videoUrl . '" type="video/mp4">
                                            <source src="' . $videoUrl . '" type="video/webm">
                                            <source src="' . $videoUrl . '" type="video/mpeg">
                                            Trình duyệt của bạn không hỗ trợ thẻ video.
                                        </video>
                                    </div>

                                    <div class="px-4 pb-4">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-400">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span>' . htmlspecialchars($filename) . '</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                                </svg>
                                                <span>' . number_format(Storage::disk('local')->size($record->video_file) / (1024 * 1024), 2) . ' MB</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4z"/>
                                                </svg>
                                                <span>' . $videoTypeLabel . '</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            })
                            ->columnSpanFull(),

                        Infolists\Components\Actions::make([
                            Infolists\Components\Actions\Action::make('download_video')
                                ->label('Tải Xuống Video')
                                ->icon('heroicon-o-arrow-down-tray')
                                ->color('success')
                                ->url(function ($record) {
                                    if ($record->video_file && Storage::disk('local')->exists($record->video_file)) {
                                        return url('/storage/youtube-videos/' . basename($record->video_file));
                                    }
                                    return null;
                                })
                                ->openUrlInNewTab()
                                ->visible(function ($record) {
                                    return $record->video_file && Storage::disk('local')->exists($record->video_file);
                                }),
                        ]),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouTubeVideos::route('/'),
            'create' => Pages\CreateYouTubeVideo::route('/create'),
            'edit' => Pages\EditYouTubeVideo::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['platformAccount']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'video_id', 'platformAccount.name'];
    }
}
