<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatformAccountResource\Pages;
use App\Models\PlatformAccount;
use App\Services\Connection\Connection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

class PlatformAccountResource extends Resource
{
    protected static ?string $model = PlatformAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quản Lý Tài Khoản';

    protected static ?string $navigationLabel = 'Danh Sách Page & Tài Khoản';

    protected static ?string $pluralLabel = 'Danh Sách Page & Tài Khoản';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông Tin Tài Khoản')
                    ->description('Chi tiết về tài khoản mạng xã hội được quản lý')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên Tài Khoản/Page')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Select::make('platform_id')
                                    ->label('Nền Tảng')
                                    ->relationship('platform', 'name')
                                    ->required(),
                            ]),

                        Forms\Components\TextInput::make('page_id')
                            ->label('Page/Account ID')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('access_token')
                            ->label('Access Token')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Trạng Thái Hoạt Động')
                            ->default(true),
                    ])
                    ->collapsible()
                    ->collapsed(false),
            ]);
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
                    ->color('primary'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên Tài Khoản/Page')
                    ->limit(30)
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable()
                    ->copyMessage('Đã sao chép tên!'),

                Tables\Columns\TextColumn::make('page_id')
                    ->label('Page ID')
                    ->limit(15)
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Đã sao chép Page ID!')
                    ->badge()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Hết Hạn Token')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        try {
                            if ($state) {
                                $date = $state instanceof \Carbon\Carbon
                                    ? $state
                                    : \Carbon\Carbon::parse($state);

                                $now = \Carbon\Carbon::now();
                                $diffInDays = $now->diffInDays($date, false);

                                if ($diffInDays < 0) {
                                    return 'Đã hết hạn';
                                } elseif ($diffInDays <= 7) {
                                    return $date->format('d/m/Y H:i');
                                } else {
                                    return $date->format('d/m/Y H:i');
                                }
                            }
                            return 'Vô thời hạn';
                        } catch (\Exception $e) {
                            Log::error('Error formatting expires_at', [
                                'state' => $state,
                                'error' => $e->getMessage(),
                            ]);
                            return 'Không hợp lệ';
                        }
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (!$state) return 'success';
                        try {
                            $date = $state instanceof \Carbon\Carbon ? $state : \Carbon\Carbon::parse($state);
                            $diffInDays = \Carbon\Carbon::now()->diffInDays($date, false);
                            if ($diffInDays < 0) return 'danger';
                            if ($diffInDays <= 7) return 'warning';
                            return 'success';
                        } catch (\Exception $e) {
                            return 'danger';
                        }
                    }),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Hoạt Động')
                    ->sortable()
                    ->alignCenter()
                    ->onColor('success')
                    ->offColor('gray')
                    ->afterStateUpdated(function ($record, $state) {
                        Notification::make()
                            ->title($state ? 'Đã Kích Hoạt!' : 'Đã Tắt!')
                            ->body('Trạng thái tài khoản "' . $record->name . '" đã được cập nhật.')
                            ->success()
                            ->duration(3000)
                            ->send();
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->badge()
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platform_id')
                    ->label('Lọc theo nền tảng')
                    ->relationship('platform', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('is_active')
                    ->label('Đang hoạt động')
                    ->query(fn($query) => $query->where('is_active', true)),

                Tables\Filters\Filter::make('token_expiring_soon')
                    ->label('Token sắp hết hạn')
                    ->query(fn($query) => $query->where('expires_at', '<=', now()->addDays(7))
                        ->whereNotNull('expires_at')),

                Tables\Filters\Filter::make('token_expired')
                    ->label('Token đã hết hạn')
                    ->query(fn($query) => $query->where('expires_at', '<', now())
                        ->whereNotNull('expires_at')),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('check_connection')
                        ->label('Kiểm Tra Kết Nối')
                        ->icon('heroicon-o-wifi')
                        ->color('success')
                        ->action(function (PlatformAccount $record) {
                            try {
                                $connectionService = new Connection();
                                $result = $connectionService->check($record);

                                if ($result && is_array($result) && $result['success']) {
                                    if (isset($result['expires_at']) && $result['expires_at'] instanceof \DateTime) {
                                        $record->expires_at = $result['expires_at'];
                                        $record->save();

                                        Notification::make()
                                            ->title('Kết Nối Thành Công!')
                                            ->body('Token hết hạn: ' . $record->expires_at->format('d/m/Y H:i:s'))
                                            ->success()
                                            ->duration(5000)
                                            ->send();
                                    } else {
                                        $record->expires_at = null;
                                        $record->save();

                                        Notification::make()
                                            ->title('Kết Nối Thành Công!')
                                            ->body('Token vô thời hạn - Kết nối ổn định.')
                                            ->success()
                                            ->duration(5000)
                                            ->send();
                                    }
                                } else {
                                    Notification::make()
                                        ->title('Kết Nối Thất Bại!')
                                        ->body('Không thể kết nối đến API. Vui lòng kiểm tra token.')
                                        ->danger()
                                        ->duration(8000)
                                        ->send();
                                }
                            } catch (\Exception $e) {
                                Log::error('Connection check failed', [
                                    'record_id' => $record->id,
                                    'error' => $e->getMessage(),
                                ]);

                                Notification::make()
                                    ->title('Lỗi Hệ Thống!')
                                    ->body('Lỗi khi kiểm tra kết nối: ' . $e->getMessage())
                                    ->danger()
                                    ->duration(10000)
                                    ->send();
                            }
                        }),

                    Action::make('view_analytics')
                        ->label('Xem Thống Kê')
                        ->icon('heroicon-o-chart-bar')
                        ->color('primary')
                        ->url(fn (PlatformAccount $record): string => static::getUrl('analytics', ['record' => $record]))
                        ->visible(fn (PlatformAccount $record): bool => $record->platform_id == 1)
                        ->openUrlInNewTab(),

                    Tables\Actions\ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth('2xl'),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa Tài Khoản')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Tài Khoản')
                        ->modalDescription('Bạn có chắc chắn muốn xóa tài khoản này? Hành động này không thể hoàn tác.'),

                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('check_all_connections')
                        ->label('Kiểm Tra Kết Nối Hàng Loạt')
                        ->icon('heroicon-o-wifi')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $successCount = 0;
                            $failureCount = 0;

                            $connectionService = new Connection();

                            foreach ($records as $record) {
                                try {
                                    $result = $connectionService->check($record);

                                    if ($result && is_array($result) && $result['success']) {
                                        if (isset($result['expires_at']) && $result['expires_at'] instanceof \DateTime) {
                                            $record->expires_at = $result['expires_at'];
                                            $record->save();
                                            $successCount++;
                                        } else {
                                            $record->expires_at = null;
                                            $record->save();
                                            $successCount++;
                                        }
                                    } else {
                                        $failureCount++;
                                    }
                                } catch (\Exception $e) {
                                    $failureCount++;
                                    Log::error("Lỗi khi kiểm tra kết nối cho tài khoản {$record->name}", [
                                        'error' => $e->getMessage(),
                                    ]);
                                }
                            }

                            Notification::make()
                                ->title('Kiểm Tra Hoàn Tất!')
                                ->body("Thành công: {$successCount} | Thất bại: {$failureCount}")
                                ->success()
                                ->duration(8000)
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('activate_all')
                        ->label('Kích Hoạt Tất Cả')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });

                            Notification::make()
                                ->title('Kích Hoạt Thành Công!')
                                ->body('Đã kích hoạt ' . $records->count() . ' tài khoản.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate_all')
                        ->label('Tắt Tất Cả')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });

                            Notification::make()
                                ->title('Tắt Thành Công!')
                                ->body('Đã tắt ' . $records->count() . ' tài khoản.')
                                ->warning()
                                ->duration(5000)
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Tất Cả Đã Chọn')
                        ->modalHeading('Xóa Các Tài Khoản Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các tài khoản này? Hành động này sẽ không thể hoàn tác.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger')
                        ->deselectRecordsAfterCompletion(),

                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có tài khoản nào')
            ->emptyStateDescription('Các tài khoản/page được quản lý sẽ xuất hiện ở đây sau khi được thêm từ Facebook App!')
            ->emptyStateIcon('heroicon-o-rectangle-stack')
            ->striped()
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlatformAccounts::route('/'),
            'analytics' => Pages\AnalyticsPlatformAccount::route('/{record}/analytics'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $activeCount = static::getModel()::where('is_active', true)->count();
        return $activeCount ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
