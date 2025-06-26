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
                            ->helperText('File video MP4, MPEG hoặc WebM, tối đa 1GB')
                            ->columnSpanFull(),
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
                    ->limit(30)
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('video_id')
                    ->label('Video ID')
                    ->searchable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép Video ID!')
                    ->badge()
                    ->color('info')
                    ->url(fn($record) => $record->video_id ? "https://www.youtube.com/watch?v={$record->video_id}" : null)
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('status')
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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('gray'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('platform_account_id')
                    ->label('Lọc theo kênh')
                    ->relationship('platformAccount', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options([
                        'public' => 'Công khai',
                        'private' => 'Riêng tư',
                        'unlisted' => 'Không công khai',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('created_today')
                    ->label('Đăng hôm nay')
                    ->query(fn($query) => $query->whereDate('created_at', today())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('upload_video')
                        ->label('Đăng Lên YouTube')
                        ->icon('heroicon-o-arrow-up') // Thay đổi icon thành heroicon-o-arrow-up
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Đăng Video Lên YouTube')
                        ->modalDescription('Video sẽ được đăng lên kênh YouTube đã chọn.')
                        ->modalSubmitActionLabel('Đăng Video')
                        ->action(function (YouTubeVideo $record) {
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
                                $snippet->setDescription($record->description);
                                $snippet->setCategoryId($record->category_id);
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

                                $status = false;
                                $handle = fopen($videoPath, 'rb');
                                while (!$status && !feof($handle)) {
                                    $chunk = fread($handle, $chunkSizeBytes);
                                    $status = $media->nextChunk($chunk);
                                }
                                fclose($handle);

                                $client->setDefer(false);

                                // Lưu video_id sau khi đăng thành công
                                $record->update(['video_id' => $status['id']]);

                                Notification::make()
                                    ->title('Thành Công!')
                                    ->body('Video đã được đăng lên YouTube thành công.')
                                    ->success()
                                    ->duration(8000)
                                    ->send();

                                // Xóa file sau khi upload
                                Storage::disk('local')->delete($record->video_file);
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi Khi Đăng Video!')
                                    ->body('Không thể đăng video: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(10000)
                                    ->send();
                            }
                        })
                        ->disabled(fn(YouTubeVideo $record) => !is_null($record->video_id)),

                    Tables\Actions\ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth('4xl'),

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
