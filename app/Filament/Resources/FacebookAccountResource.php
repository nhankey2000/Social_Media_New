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

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    protected static ?string $navigationLabel = 'Tài Khoản Quản Lý Page';
    protected static ?string $pluralLabel = 'Tài Khoản Quản Lý Page';
    protected static ?string $navigationGroup = 'Quản Lý Tài Khoản';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Select::make('platform_id')
                                    ->label('🌐 Nền tảng')
                                    ->required()
                                    ->options(Platform::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('app_id')
                                    ->label('🔑 App ID')
                                    ->placeholder('Nhập Facebook App ID...')
                                    ->required(),

                                Forms\Components\TextInput::make('app_secret')
                                    ->label('🔐 App Secret')
                                    ->placeholder('Nhập Facebook App Secret...')
                                    ->required(),

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
                Tables\Columns\TextColumn::make('platform.name')
                    ->label('Nền tảng')
                    ->sortable(),

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
                            $platform = Platform::find($record->platform_id);
                            $facebookService = new FacebookService();
                            $tempPlatformAccount = new PlatformAccount([
                                'access_token' => $record->access_token,
                                'is_active' => true,
                            ]);

                            if ($platform->name === 'Facebook') {
                                // Handle Facebook Pages
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

                                $record->update(['access_token' => $longLivedToken]);

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
                                }

                                Notification::make()
                                    ->title('Thành Công')
                                    ->body('Đã lấy và lưu danh sách trang Facebook với Page Access Token vô thời hạn thành công.')
                                    ->success()
                                    ->send();
                            } elseif ($platform->name === 'Instagram') {
                                // Handle Instagram Accounts
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

                                $record->update(['access_token' => $longLivedToken]);

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
                                }

                                Notification::make()
                                    ->title('Thành Công')
                                    ->body('Đã lấy và lưu danh sách tài khoản Instagram thành công.')
                                    ->success()
                                    ->send();
                            } else {
                                throw new \Exception('Nền tảng không được hỗ trợ.');
                            }
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Lỗi')
                                ->body('Không thể lấy danh sách: ' . $e->getMessage())
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
            'edit' => Pages\EditFacebookAccount::route('/{record}/edit'),
        ];
    }
}
