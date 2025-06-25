<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacebookAccountResource\Pages;
use App\Models\FacebookAccount;
use App\Models\Platform;
use App\Models\PlatformAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use App\Services\FacebookService;
use Illuminate\Support\Facades\Auth;

class FacebookAccountResource extends Resource
{
    protected static ?string $model = FacebookAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Tài Khoản Quản Lý Page';

    protected static ?string $pluralLabel = 'Tài Khoản Quản Lý Page';

    protected static ?string $navigationGroup = 'Quản Lý Tài Khoản';

    protected static ?string $recordTitleAttribute = 'app_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Cấu Hình Ứng Dụng Facebook')
                    ->description('Thiết lập thông tin ứng dụng Facebook để quản lý các trang và tài khoản')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('platform_id')
                                    ->label('Nền Tảng Mạng Xã Hội')
                                    ->required()
                                    ->options(Platform::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->reactive()
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100'
                                    ])
                                    ->helperText('Chọn nền tảng mạng xã hội (Facebook, Instagram)')
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        // Optional: Handle state update if needed
                                    })
                                    ->suffixActions([
                                        Forms\Components\Actions\Action::make('add_platform')
                                            ->label('Thêm Nền Tảng Mới')
                                            ->icon('heroicon-o-plus-circle')
                                            ->color('success')
                                            ->modalHeading('Tạo Nền Tảng Mới')
                                            ->modalSubmitActionLabel('Tạo Nền Tảng')
                                            ->modalCancelActionLabel('Hủy Bỏ')
                                            ->modalWidth('md')
                                            ->form([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Tên Nền Tảng')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Ví dụ: Facebook, Instagram, TikTok...')
                                                    ->extraAttributes([
                                                        'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-lg focus:border-green-500 focus:ring-green-200'
                                                    ])
                                                    ->helperText('Nhập tên nền tảng mạng xã hội mới'),
                                            ])
                                            ->action(function (array $data, $livewire) {
                                                if (Platform::where('name', $data['name'])->exists()) {
                                                    Notification::make()
                                                        ->title('Nền tảng đã tồn tại!')
                                                        ->body('Nền tảng "' . $data['name'] . '" đã có trong hệ thống.')
                                                        ->danger()
                                                        ->duration(5000)
                                                        ->send();
                                                    return;
                                                }

                                                $platform = Platform::create([
                                                    'name' => $data['name'],
                                                ]);

                                                $livewire->dispatch('refreshForm');

                                                Notification::make()
                                                    ->title('Tạo nền tảng thành công!')
                                                    ->body('Nền tảng "' . $data['name'] . '" đã được thêm vào hệ thống.')
                                                    ->success()
                                                    ->duration(5000)
                                                    ->send();

                                                $livewire->form->fill([
                                                    'platform_id' => $platform->id,
                                                ]);
                                            }),
                                    ]),

                                Forms\Components\TextInput::make('app_id')
                                    ->label('Facebook App ID')
                                    ->placeholder('Nhập App ID từ Facebook Developer...')
                                    ->required()
                                    ->maxLength(255)
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 font-mono'
                                    ])
                                    ->helperText('ID ứng dụng từ Facebook Developer Console'),
                            ]),

                        Forms\Components\TextInput::make('app_secret')
                            ->label('Facebook App Secret')
                            ->placeholder('Nhập App Secret từ Facebook Developer...')
                            ->required()
                            ->password()
                            ->revealable()
                            ->maxLength(255)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-300 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 font-mono'
                            ])
                            ->helperText('Secret key của ứng dụng (giữ bí mật)')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('redirect_url')
                            ->label('Redirect URL')
                            ->placeholder('Nhập Redirect URL từ Facebook Developer...')
                            ->required()
                            ->url()
                            ->maxLength(255)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-teal-50 to-cyan-50 border-2 border-teal-300 rounded-xl focus:border-teal-500 focus:ring-4 focus:ring-teal-100 font-mono'
                            ])
                            ->helperText('URL redirect được cấu hình trong Facebook Developer Console'),

                        Forms\Components\Textarea::make('access_token')
                            ->label('User Access Token')
                            ->placeholder('Dán User Access Token ngắn hạn tại đây...')
                            ->required()
                            ->rows(4)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-br from-green-50 to-teal-50 border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 font-mono text-sm resize-none'
                            ])
                            ->helperText('Token ngắn hạn để lấy danh sách Page (sẽ được chuyển thành long-lived token)')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 border-2 border-blue-600 rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-500'
                    ]),

                Forms\Components\Section::make('Hướng Dẫn Sử Dụng')
                    ->description('Các bước để thiết lập và sử dụng tính năng này')
                    ->icon('heroicon-o-light-bulb')
                    ->schema([
                        Forms\Components\Card::make([
                            Forms\Components\View::make('filament.components.api-instructions')
                        ])
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-300 rounded-xl p-6 text-sm text-gray-800 leading-relaxed whitespace-pre-line'
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-yellow-900 via-orange-900 to-red-900 border-2 border-yellow-600 rounded-2xl shadow-2xl hover:shadow-yellow-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('platform.name')
                    ->label('Nền Tảng')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->icon('heroicon-o-globe-alt'),

                Tables\Columns\TextColumn::make('app_id')
                    ->label('App ID')
                    ->searchable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép App ID!')
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\TextColumn::make('app_secret')
                    ->label('App Secret')
                    ->limit(15)
                    ->fontFamily('mono')
                    ->formatStateUsing(fn($state) => str_repeat('*', 12) . substr($state, -3))
                    ->tooltip('Click để xem đầy đủ')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('access_token')
                    ->label('Access Token')
                    ->limit(20)
                    ->fontFamily('mono')
                    ->formatStateUsing(fn($state) => substr($state, 0, 15) . '...' . substr($state, -5))
                    ->tooltip('User Access Token (được ẩn bớt)')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('redirect_url')
                    ->label('Redirect URL')
                    ->limit(30)
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép Redirect URL!')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Cập Nhật Cuối')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since()
                    ->badge()
                    ->color('gray')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('redirect_url', 'asc') // Sắp xếp mặc định theo redirect_url tăng dần
            ->filters([
                Tables\Filters\SelectFilter::make('platform_id')
                    ->label('Lọc theo nền tảng')
                    ->relationship('platform', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('created_today')
                    ->label('Tạo hôm nay')
                    ->query(fn($query) => $query->whereDate('created_at', today())),
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

                    Tables\Actions\Action::make('fetch_pages')
                        ->label('Lấy Danh Sách Trang')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Lấy Danh Sách Trang/Tài Khoản')
                        ->modalDescription('Hệ thống sẽ sử dụng Access Token để lấy danh sách trang Facebook hoặc tài khoản Instagram.')
                        ->modalSubmitActionLabel('Bắt Đầu Lấy Dữ Liệu')
                        ->action(function (FacebookAccount $record) {
                            try {
                                $platform = Platform::find($record->platform_id);
                                $facebookService = new FacebookService();
                                $tempPlatformAccount = new PlatformAccount([
                                    'access_token' => $record->access_token,
                                    'is_active' => true,
                                ]);

                                if ($platform->name === 'Facebook') {
                                    $pages = $facebookService->fetchUserPages(
                                        $tempPlatformAccount,
                                        $record->app_id,
                                        $record->app_secret
                                    );

                                    $longLivedToken = $facebookService->getLongLivedUserAccessToken(
                                        $record->access_token,
                                        $record->app_id,
                                        $record->app_secret
                                    );

                                    $record->update([
                                        'access_token' => $longLivedToken,
                                        'redirect_url' => $record->redirect_url, // Giữ nguyên redirect_url
                                    ]);

                                    $pageCount = 0;
                                    foreach ($pages as $page) {
                                        PlatformAccount::updateOrCreate(
                                            [
                                                'platform_id' => $record->platform_id,
                                                'page_id' => $page['page_id'],
                                            ],
                                            [
                                                'name' => $page['name'],
                                                'access_token' => $page['page_access_token'],
                                                'app_id' => $record->app_id,
                                                'app_secret' => $record->app_secret,
                                                'is_active' => true,
                                            ]
                                        );
                                        $pageCount++;
                                    }

                                    Notification::make()
                                        ->title('Thành Công!')
                                        ->body("Đã lấy và lưu {$pageCount} trang Facebook với Page Access Token vô thời hạn.")
                                        ->success()
                                        ->duration(8000)
                                        ->send();

                                } elseif ($platform->name === 'Instagram') {
                                    $accounts = $facebookService->fetchInstagramAccounts(
                                        $tempPlatformAccount,
                                        $record->app_id,
                                        $record->app_secret
                                    );

                                    $longLivedToken = $facebookService->getLongLivedUserAccessToken(
                                        $record->access_token,
                                        $record->app_id,
                                        $record->app_secret
                                    );

                                    $record->update([
                                        'access_token' => $longLivedToken,
                                        'redirect_url' => $record->redirect_url, // Giữ nguyên redirect_url
                                    ]);

                                    $accountCount = 0;
                                    foreach ($accounts as $account) {
                                        PlatformAccount::updateOrCreate(
                                            [
                                                'platform_id' => $record->platform_id,
                                                'page_id' => $account['instagram_business_account_id'],
                                            ],
                                            [
                                                'name' => $account['username'],
                                                'access_token' => $account['access_token'],
                                                'app_id' => $record->app_id,
                                                'app_secret' => $record->app_secret,
                                                'is_active' => true,
                                            ]
                                        );
                                        $accountCount++;
                                    }

                                    Notification::make()
                                        ->title('Thành Công!')
                                        ->body("Đã lấy và lưu {$accountCount} tài khoản Instagram Business.")
                                        ->success()
                                        ->duration(8000)
                                        ->send();

                                } else {
                                    throw new \Exception('Nền tảng "' . $platform->name . '" chưa được hỗ trợ.');
                                }

                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi Khi Lấy Dữ Liệu!')
                                    ->body('Không thể lấy danh sách: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(10000)
                                    ->send();
                            }
                        }),

                    Tables\Actions\Action::make('refresh_token')
                        ->label('Làm Mới Token')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Làm Mới Access Token')
                        ->modalDescription('Gia hạn Access Token để duy trì kết nối với Facebook API.')
                        ->action(function (FacebookAccount $record) {
                            try {
                                $facebookService = new FacebookService();
                                $newToken = $facebookService->getLongLivedUserAccessToken(
                                    $record->access_token,
                                    $record->app_id,
                                    $record->app_secret
                                );

                                $record->update([
                                    'access_token' => $newToken,
                                    'redirect_url' => $record->redirect_url, // Giữ nguyên redirect_url
                                ]);

                                Notification::make()
                                    ->title('Thành Công!')
                                    ->body('Access Token đã được làm mới và gia hạn.')
                                    ->success()
                                    ->duration(5000)
                                    ->send();

                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Lỗi!')
                                    ->body('Không thể làm mới token: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(8000)
                                    ->send();
                            }
                        }),

                    Tables\Actions\Action::make('view_pages')
                        ->label('Xem Trang Quản Lý')
                        ->icon('heroicon-o-building-office')
                        ->color('secondary')
                        ->url(fn() => '/admin/platform-accounts')
                        ->openUrlInNewTab(),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa Tài Khoản')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Tài Khoản Facebook')
                        ->modalDescription('Bạn có chắc chắn muốn xóa tài khoản này? Tất cả trang được quản lý sẽ bị ảnh hưởng.'),

                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('refresh_all_tokens')
                        ->label('Làm Mới Tất Cả Token')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Làm Mới Token Hàng Loạt')
                        ->modalDescription('Làm mới Access Token cho tất cả tài khoản đã chọn.')
                        ->action(function ($records) {
                            $successCount = 0;
                            $errorCount = 0;

                            foreach ($records as $record) {
                                try {
                                    $facebookService = new FacebookService();
                                    $newToken = $facebookService->getLongLivedUserAccessToken(
                                        $record->access_token,
                                        $record->app_id,
                                        $record->app_secret
                                    );

                                    $record->update([
                                        'access_token' => $newToken,
                                        'redirect_url' => $record->redirect_url, // Giữ nguyên redirect_url
                                    ]);
                                    $successCount++;

                                } catch (\Exception $e) {
                                    $errorCount++;
                                }
                            }

                            Notification::make()
                                ->title('Hoàn Tất!')
                                ->body("Thành công: {$successCount} | Lỗi: {$errorCount}")
                                ->success()
                                ->duration(8000)
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Tất Cả Đã Chọn')
                        ->modalHeading('Xóa Các Tài Khoản Facebook')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các tài khoản này? Hành động này không thể hoàn tác.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger'),

                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có tài khoản Facebook nào')
            ->emptyStateDescription('Hãy thêm tài khoản Facebook đầu tiên để bắt đầu quản lý trang!')
            ->emptyStateIcon('heroicon-o-building-office-2')
            ->striped()
            ->defaultSort('redirect_url', 'asc') // Sắp xếp mặc định theo redirect_url tăng dần
            ->recordUrl(null)
            ->poll('300s'); // Auto refresh every 5 minutes
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacebookAccounts::route('/'),
            // 'create' => Pages\CreateFacebookAccount::route('/create'),
            'edit' => Pages\EditFacebookAccount::route('/{record}/edit'),
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
        return parent::getGlobalSearchEloquentQuery()->with(['platform']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['app_id', 'platform.name', 'redirect_url'];
    }
}
