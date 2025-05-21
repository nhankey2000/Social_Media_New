<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FacebookAccountResource\Pages;
use App\Models\FacebookAccount;
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

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Tài Khoản Quản Lý Page';
    protected static ?string $pluralLabel = 'Tài Khoản Quản Lý Page';
    protected static ?string $navigationGroup = 'Quản Lý Tài Khoản';
    // public static function canViewAny(): bool
    // {
    //     // ✅ Kiểm tra xem người dùng hiện tại có phải là admin hay không
    //     // Nếu đúng, cho phép hiển thị danh sách bản ghi của resource
    //     return Auth::user()->role === 'admin';
    // }
    
    // /**
    //  * ✅ Tuỳ chọn: Ẩn menu điều hướng trong sidebar nếu không phải admin
    //  * (người dùng không phải admin sẽ không thấy resource này trong sidebar của Filament)
    //  */
    // public static function shouldRegisterNavigation(): bool
    // {
    //     // Chỉ hiển thị resource trên sidebar nếu người dùng là admin
    //     return Auth::user()->role === 'admin';
    // }
    
   public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make()
                ->schema([

                    Forms\Components\Grid::make()
                        ->schema([
                            Forms\Components\TextInput::make('app_id')
                                ->label('🔑 App ID')
                                ->placeholder('Nhập Facebook App ID...')
                                ->required()
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('app_secret')
                                ->label('🔐 App Secret')
                                ->placeholder('Nhập Facebook App Secret...')
                                ->required()
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('access_token')
                                ->label('🔓 User Access Token')
                                ->placeholder('Dán Access Token tại đây...')
                                ->required()
                                ->helperText('Dùng token ngắn hạn để lấy danh sách Page.')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Forms\Components\Card::make([
                        Forms\Components\View::make('filament.components.api-instructions')
                    ])
                    ->columnSpanFull()
                    ->extraAttributes([
                        'class' => 'bg-gray-50 border border-gray-200 rounded-xl shadow-sm'
                    ]),

                ])
                ->columns(1)
                ->collapsible()
                ->collapsed(false),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('app_id')
                    ->label('App ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('app_secret')
                    ->label('App Secret')
                    ->limit(20),
                Tables\Columns\TextColumn::make('access_token')
                    ->label('User Access Token')
                    ->limit(20),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Sửa'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa'),
                Tables\Actions\Action::make('fetch_pages')
                    ->label('Lấy Danh Sách Trang')
                    ->icon('heroicon-o-arrow-path')
                    ->color('success')
                    ->action(function (FacebookAccount $record) {
                        try {
                            $tempPlatformAccount = new PlatformAccount([
                                'access_token' => $record->access_token,
                                'is_active' => true,
                            ]);

                            $facebookService = new FacebookService();
                            $pages = $facebookService->fetchUserPages($tempPlatformAccount, $record->app_id, $record->app_secret);

                            $longLivedToken = $facebookService->getLongLivedUserAccessToken($record->access_token, $record->app_id, $record->app_secret);
                            $record->update(['access_token' => $longLivedToken]);

                            foreach ($pages as $page) {
                                PlatformAccount::updateOrCreate(
                                    [
                                        'platform_id' => 1,
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
                            }

                            Notification::make()
                                ->title('Thành Công')
                                ->body('Đã lấy và lưu danh sách trang với Page Access Token vô thời hạn thành công.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Lỗi')
                                ->body('Không thể lấy danh sách trang: ' . $e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Xóa Tất Cả'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFacebookAccounts::route('/'),
            // 'create' => Pages\CreateFacebookAccount::route('/create'),
            'edit' => Pages\EditFacebookAccount::route('/{record}/edit'),
        ];
    }
}