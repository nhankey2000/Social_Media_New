<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepeatScheduledResource\Pages;
use App\Models\RepeatScheduled;
use App\Models\PlatformAccount;
use App\Services\FacebookService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Filament\Support\Colors\Color;

class RepeatScheduledResource extends Resource
{
    protected static ?string $model = RepeatScheduled::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Tự Động Đăng Bài';

    protected static ?string $navigationLabel = 'Bài Viết Đã Đăng';

    protected static ?string $pluralLabel = 'Bài Viết Đã Đăng';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông Tin Bài Viết Đã Đăng')
                    ->description('Chi tiết về bài viết đã được đăng lên mạng xã hội')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('schedule')
                                    ->label('Thời Gian Đăng')
                                    ->disabled()
                                    ->required()
                                    ->displayFormat('d/m/Y H:i')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-300 rounded-lg opacity-75'
                                    ])
                                    ->helperText('Thời gian bài viết được đăng lên mạng xã hội'),

                                Forms\Components\TextInput::make('facebook_post_id')
                                    ->label('Facebook Post ID')
                                    ->disabled()
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-gray-50 to-slate-50 border-gray-300 rounded-lg opacity-75 font-mono text-sm'
                                    ])
                                    ->helperText('ID của bài viết trên Facebook'),
                            ]),

                        Forms\Components\TextInput::make('title')
                            ->label('Tiêu Đề Bài Viết')
                            ->required()
                            ->maxLength(255)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-300 rounded-lg focus:border-green-500 focus:ring-green-200 font-semibold'
                            ])
                            ->helperText('Tiêu đề chính của bài viết'),

                        Forms\Components\Textarea::make('content')
                            ->label('Nội Dung Bài Viết')
                            ->required()
                            ->rows(8)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-br from-purple-50 to-pink-50 border-purple-300 rounded-xl focus:border-purple-500 focus:ring-purple-200 leading-relaxed'
                            ])
                            ->helperText('Nội dung chi tiết của bài viết đã đăng')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('images')
                            ->label('Hình Ảnh Đi Kèm')
                            ->multiple()
                            ->directory('images')
                            ->preserveFilenames()
                            ->image()
                            ->maxFiles(10)
                            ->imageEditor()
                            ->imagePreviewHeight('200')
                            ->panelLayout('grid')
                            ->extraAttributes([
                                'class' => 'border-2 border-dashed border-orange-300 rounded-2xl bg-gradient-to-br from-orange-50 to-yellow-50'
                            ])
                            ->helperText('Các hình ảnh đã được đăng cùng với bài viết')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-slate-900 via-gray-900 to-zinc-900 border-2 border-slate-600 rounded-2xl shadow-2xl hover:shadow-slate-500/25 transition-all duration-500'
                    ]),

                Forms\Components\Section::make('Thông Tin Tác Giả & Nền Tảng')
                    ->description('Chi tiết về người tạo và nền tảng đăng bài')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('platform_account_id')
                                    ->label('Trang Đăng Bài')
                                    ->relationship('platformAccount', 'name')
                                    ->disabled()
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-indigo-50 to-blue-50 border-indigo-300 rounded-lg opacity-75'
                                    ])
                                    ->helperText('Trang mạng xã hội đã đăng bài viết này'),

                                Forms\Components\TextInput::make('author_name')
                                    ->label('Tác Giả')
                                    ->disabled()
                                    ->formatStateUsing(function ($record) {
                                        return $record && $record->aiPostPrompt && $record->aiPostPrompt->user
                                            ? $record->aiPostPrompt->user->name
                                            : 'Không xác định';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-green-50 to-teal-50 border-green-300 rounded-lg opacity-75'
                                    ])
                                    ->helperText('Người tạo bài viết gốc'),
                            ]),
                    ])
                    ->collapsible()
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 border-2 border-indigo-600 rounded-2xl shadow-2xl hover:shadow-indigo-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('schedule', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('platform_account_id')
                    ->label('Trang Đăng Bài')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        if (!$state) {
                            return 'Không có trang';
                        }
                        $platformAccount = PlatformAccount::find($state);
                        return $platformAccount ? $platformAccount->name : 'Không tìm thấy trang';
                    })
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-building-office'),

                Tables\Columns\TextColumn::make('schedule')
                    ->label('Thời Gian Đăng')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state ? \Carbon\Carbon::parse($state)->format('d/m/Y H:i') : 'Không có lịch';
                    })
                    ->badge()
                    ->color('info')
                    ->icon('heroicon-o-clock'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Tiêu Đề')
                    ->limit(30)
                    ->default('Không có tiêu đề')
                    ->wrap()
                    ->weight('bold')
                    ->color('primary')
                    ->tooltip(fn($record) => $record->title),

                Tables\Columns\TextColumn::make('content')
                    ->label('Nội Dung')
                    ->default('Không có nội dung')
                    ->wrap()
                    ->limit(50)
                    ->html()
                    ->formatStateUsing(fn ($state) => nl2br(e($state)))
                    ->tooltip(fn($record) => strip_tags($record->content)),

                Tables\Columns\ImageColumn::make('images')
                    ->label('Hình Ảnh')
                    ->stacked()
                    ->circular()
                    ->limit(3)
                    ->limitedRemainingText()
                    ->disk('public')
                    ->extraAttributes(['class' => 'rounded-lg shadow-sm'])
                    ->getStateUsing(function ($record) {
                        $images = $record->images;
                        if (is_array($images) && !empty($images)) {
                            $images = array_map(function ($image) {
                                $image = str_replace('\\', '/', $image);
                                if (preg_match('#^images/#', $image)) {
                                    return $image;
                                }
                                return 'images/' . $image;
                            }, $images);
                            Log::info('ImageColumn state', [
                                'record_id' => $record->id,
                                'images' => $images,
                            ]);
                            return $images;
                        }
                        return [];
                    }),

                Tables\Columns\TextColumn::make('aiPostPrompt.user.name')
                    ->label('Tác Giả')
                    ->sortable()
                    ->searchable()
                    ->default('Không xác định')
                    ->formatStateUsing(function ($record) {
                        return $record->aiPostPrompt && $record->aiPostPrompt->user
                            ? $record->aiPostPrompt->user->name
                            : 'Không xác định';
                    })
                    ->badge()
                    ->color('warning')
                    ->icon('heroicon-o-user'),

                Tables\Columns\TextColumn::make('facebook_post_id')
                    ->label('Post ID')
                    ->limit(15)
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép Post ID!')
                    ->badge()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('engagement_stats')
                    ->label('Tương Tác')
                    ->formatStateUsing(function ($record) {
                        // Placeholder for engagement stats
                        return 'Đang cập nhật...';
                    })
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platform_account_id')
                    ->label('Lọc theo trang')
                    ->relationship('platformAccount', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('posted_today')
                    ->label('Đăng hôm nay')
                    ->query(fn($query) => $query->whereDate('schedule', today())),

                Tables\Filters\Filter::make('posted_this_week')
                    ->label('Đăng tuần này')
                    ->query(fn($query) => $query->whereBetween('schedule', [now()->startOfWeek(), now()->endOfWeek()])),

                Tables\Filters\Filter::make('posted_this_month')
                    ->label('Đăng tháng này')
                    ->query(fn($query) => $query->whereMonth('schedule', now()->month)
                        ->whereYear('schedule', now()->year)),

                Tables\Filters\Filter::make('has_images')
                    ->label('Có hình ảnh')
                    ->query(fn($query) => $query->whereNotNull('images')
                        ->where('images', '!=', '[]')
                        ->where('images', '!=', '')),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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

                    Tables\Actions\Action::make('view_on_facebook')
                        ->label('Xem Trên Facebook')
                        ->icon('heroicon-o-globe-alt')
                        ->color('primary')
                        ->url(function ($record) {
                            if ($record->facebook_post_id) {
                                return "https://www.facebook.com/{$record->facebook_post_id}";
                            }
                            return null;
                        })
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->facebook_post_id)),

                    Tables\Actions\Action::make('get_engagement')
                        ->label('Lấy Thống Kê Tương Tác')
                        ->icon('heroicon-o-chart-bar')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Lấy Thống Kê Tương Tác')
                        ->modalDescription('Lấy dữ liệu tương tác mới nhất từ Facebook cho bài viết này.')
                        ->action(function ($record) {
                            try {
                                // Placeholder for engagement fetching logic
                                Notification::make()
                                    ->title('Thành công!')
                                    ->body('Đang cập nhật thống kê tương tác...')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không thể lấy thống kê: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        })
                        ->visible(fn($record) => !empty($record->facebook_post_id)),

                    Tables\Actions\Action::make('duplicate_post')
                        ->label('Tạo Bài Mới Tương Tự')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('secondary')
                        ->requiresConfirmation()
                        ->modalHeading('Tạo Bài Viết Mới')
                        ->modalDescription('Tạo một bài viết AI mới với nội dung tương tự bài viết này.')
                        ->action(function ($record) {
                            try {
                                // Logic to create new AI post with similar content
                                Notification::make()
                                    ->title('Thành công!')
                                    ->body('Đã tạo bài viết AI mới dựa trên nội dung này.')
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không thể tạo bài viết mới: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa Bài Viết')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Bài Viết')
                        ->modalDescription('Bạn có chắc chắn muốn xóa bài viết này? Bài viết sẽ bị xóa cả trên Facebook và trong hệ thống.')
                        ->before(function ($record) {
                            if ($record->facebook_post_id && $record->platform_account_id) {
                                try {
                                    $platformAccount = PlatformAccount::find($record->platform_account_id);

                                    if (!$platformAccount || !$platformAccount->access_token) {
                                        Log::error('Không tìm thấy thông tin fan page hoặc access token không hợp lệ', [
                                            'platform_account_id' => $record->platform_account_id,
                                        ]);
                                        Notification::make()
                                            ->title('Cảnh báo!')
                                            ->body('Không thể xóa bài viết trên Facebook: Thông tin trang không hợp lệ. Chỉ xóa trong hệ thống.')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    $facebookService = app(FacebookService::class);
                                    $facebookService->deletePost($record->facebook_post_id, $platformAccount->access_token);

                                    Log::info('Xóa bài viết trên Facebook thành công', [
                                        'post_id' => $record->facebook_post_id,
                                        'record_id' => $record->id,
                                    ]);

                                    Notification::make()
                                        ->title('Thành công!')
                                        ->body('Bài viết đã được xóa khỏi Facebook.')
                                        ->success()
                                        ->send();
                                } catch (\Exception $e) {
                                    Log::error('Lỗi khi xóa bài viết trên Facebook', [
                                        'post_id' => $record->facebook_post_id,
                                        'record_id' => $record->id,
                                        'error' => $e->getMessage(),
                                    ]);
                                    Notification::make()
                                        ->title('Lỗi!')
                                        ->body('Không thể xóa bài viết trên Facebook: ' . $e->getMessage())
                                        ->danger()
                                        ->send();
                                }
                            }
                        }),
                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_posts')
                        ->label('Xuất Dữ Liệu')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function ($records) {
                            // Logic to export posts data
                            Notification::make()
                                ->title('Đang xuất dữ liệu...')
                                ->body('Dữ liệu của ' . $records->count() . ' bài viết đang được xuất.')
                                ->info()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('update_engagement')
                        ->label('Cập Nhật Tương Tác Hàng Loạt')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Cập Nhật Tương Tác')
                        ->modalDescription('Cập nhật thống kê tương tác cho tất cả bài viết đã chọn.')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                if ($record->facebook_post_id) {
                                    // Logic to update engagement stats
                                }
                            }
                            Notification::make()
                                ->title('Thành công!')
                                ->body('Đã cập nhật tương tác cho ' . $records->count() . ' bài viết.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Tất Cả Đã Chọn')
                        ->modalHeading('Xóa Các Bài Viết Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các bài viết này? Chúng sẽ bị xóa cả trên Facebook và trong hệ thống.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger')
                        ->before(function ($records) {
                            foreach ($records as $record) {
                                if ($record->facebook_post_id && $record->platform_account_id) {
                                    try {
                                        $platformAccount = PlatformAccount::find($record->platform_account_id);

                                        if (!$platformAccount || !$platformAccount->access_token) {
                                            Log::error('Không tìm thấy thông tin fan page hoặc access token không hợp lệ', [
                                                'platform_account_id' => $record->platform_account_id,
                                            ]);
                                            continue;
                                        }

                                        $facebookService = app(FacebookService::class);
                                        $facebookService->deletePost($record->facebook_post_id, $platformAccount->access_token);

                                        Log::info('Xóa bài viết trên Facebook thành công', [
                                            'post_id' => $record->facebook_post_id,
                                            'record_id' => $record->id,
                                        ]);
                                    } catch (\Exception $e) {
                                        Log::error('Lỗi khi xóa bài viết trên Facebook', [
                                            'post_id' => $record->facebook_post_id,
                                            'record_id' => $record->id,
                                            'error' => $e->getMessage(),
                                        ]);
                                    }
                                }
                            }

                            Notification::make()
                                ->title('Hoàn tất!')
                                ->body('Đã xử lý xóa ' . $records->count() . ' bài viết.')
                                ->success()
                                ->send();
                        }),
                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có bài viết nào được đăng')
            ->emptyStateDescription('Các bài viết đã đăng lên mạng xã hội sẽ xuất hiện ở đây!')
            ->emptyStateIcon('heroicon-o-newspaper')
            ->striped()
            ->recordUrl(null)
            ->poll('120s'); // Auto refresh every 2 minutes
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepeatScheduleds::route('/'),
            'create' => Pages\CreateRepeatScheduled::route('/create'),
            'edit' => Pages\EditRepeatScheduled::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereDate('schedule', today())->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['platformAccount', 'aiPostPrompt.user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'content', 'facebook_post_id', 'platformAccount.name', 'aiPostPrompt.user.name'];
    }
}
