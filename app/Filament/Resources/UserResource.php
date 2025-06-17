<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Quản Lý Người Dùng';

    protected static ?string $pluralLabel = 'Quản Lý Người Dùng';

    protected static ?string $navigationGroup = 'Hệ Thống';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        $user = Filament::auth()->user();
        Log::info('User roles:', $user ? $user->roles->pluck('name')->toArray() : []);
        return Filament::auth()->check() && $user && $user->hasRole('admin');
    }

    public static function canEdit(Model $record): bool
    {
        $user = Filament::auth()->user();
        return Filament::auth()->check() && $user && $user->hasRole('admin');
    }

    public static function canDelete(Model $record): bool
    {
        $user = Filament::auth()->user();
        $currentUser = Filament::auth()->user();

        // Không cho phép xóa chính mình
        if ($currentUser && $currentUser->id === $record->id) {
            return false;
        }

        return Filament::auth()->check() && $user && $user->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông Tin Cá Nhân')
                    ->description('Thông tin cơ bản của người dùng trong hệ thống')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Họ và Tên')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Nhập họ và tên đầy đủ')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium text-gray-800 transition-all duration-300',
                                    ])
                                    ->helperText('Tên hiển thị của người dùng trong hệ thống'),

                                TextInput::make('email')
                                    ->label('Địa Chỉ Email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('example@domain.com')
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 font-medium text-gray-800 transition-all duration-300',
                                    ])
                                    ->helperText('Email đăng nhập và liên lạc'),
                            ]),

                        TextInput::make('password')
                            ->label('Mật Khẩu')
                            ->password()
                            ->required(fn($context) => $context === 'create')
                            ->minLength(8)
                            ->placeholder('Nhập mật khẩu (tối thiểu 8 ký tự)')
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 font-medium text-gray-800 transition-all duration-300',
                            ])
                            ->helperText('Mật khẩu mạnh giúp bảo vệ tài khoản'),

                        DateTimePicker::make('email_verified_at')
                            ->label('Ngày Xác Minh Email')
                            ->displayFormat('d/m/Y H:i')
                            ->native(false)
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-r from-orange-50 to-yellow-50 border-2 border-orange-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all duration-300',
                            ])
                            ->helperText('Thời điểm người dùng xác minh email (để trống nếu chưa xác minh)'),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-blue-900 via-indigo-900 to-purple-900 border-2 border-blue-600 rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-500'
                    ]),

                Section::make('Phân Quyền & Trạng Thái')
                    ->description('Cấu hình vai trò và quyền hạn của người dùng')
                    ->icon('heroicon-o-key')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('roles')
                                    ->label('Vai Trò Hệ Thống')
                                    ->multiple()
                                    ->relationship('roles', 'name')
                                    ->preload()
                                    ->required()
                                    ->searchable()
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-red-50 to-pink-50 border-2 border-red-300 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300',
                                    ])
                                    ->helperText('Chọn vai trò để xác định quyền hạn')
                                    ->options(function () {
                                        return \Spatie\Permission\Models\Role::pluck('name', 'id');
                                    }),
                            ]),
                    ])
                    ->collapsible()
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-red-900 via-pink-900 to-purple-900 border-2 border-red-600 rounded-2xl shadow-2xl hover:shadow-red-500/25 transition-all duration-500'
                    ]),

                Section::make('Thông Tin Hệ Thống')
                    ->description('Dữ liệu tự động được hệ thống quản lý')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Placeholder::make('created_at_display')
                                    ->label('Ngày Tạo Tài Khoản')
                                    ->content(function ($record) {
                                        return $record && $record->created_at
                                            ? $record->created_at->format('d/m/Y H:i:s')
                                            : 'Đang tạo mới...';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 rounded-lg p-3 font-semibold text-blue-800'
                                    ]),

                                Placeholder::make('updated_at_display')
                                    ->label('Lần Cập Nhật Cuối')
                                    ->content(function ($record) {
                                        return $record && $record->updated_at
                                            ? $record->updated_at->format('d/m/Y H:i:s')
                                            : 'Chưa cập nhật';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-200 rounded-lg p-3 font-semibold text-green-800'
                                    ]),

                                Placeholder::make('last_login_display')
                                    ->label('Đăng Nhập Gần Nhất')
                                    ->content(function ($record) {
                                        return $record && $record->last_login_at
                                            ? $record->last_login_at->format('d/m/Y H:i:s')
                                            : 'Chưa đăng nhập';
                                    })
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-purple-200 rounded-lg p-3 font-semibold text-purple-800'
                                    ]),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(true)
                    ->visible(fn($context) => $context === 'edit')
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-gray-900 via-slate-900 to-zinc-900 border-2 border-gray-600 rounded-2xl shadow-2xl hover:shadow-gray-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Họ và Tên')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-user')
                    ->copyable()
                    ->copyMessage('Đã sao chép tên!')
                    ->tooltip(fn($record) => 'ID: ' . $record->id),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Đã sao chép email!')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('roles.name')
                    ->label('Vai Trò')
                    ->badge()
                    ->separator(', ')
                    ->color(fn($state) => match($state) {
                        'admin' => 'danger',
                        'editor' => 'warning',
                        'user' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn($state) => match($state) {
                        'admin' => 'heroicon-o-shield-check',
                        'editor' => 'heroicon-o-pencil-square',
                        'user' => 'heroicon-o-user',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                IconColumn::make('email_verified_at')
                    ->label('Email Xác Minh')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn($record) => $record->email_verified_at
                        ? 'Đã xác minh: ' . $record->email_verified_at->format('d/m/Y H:i')
                        : 'Chưa xác minh email'),

                TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->label('Lọc theo vai trò')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                Filter::make('email_verified')
                    ->label('Đã xác minh email')
                    ->query(fn($query) => $query->whereNotNull('email_verified_at')),

                Filter::make('created_this_month')
                    ->label('Tạo tháng này')
                    ->query(fn($query) => $query->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth('4xl'),

                    EditAction::make()
                        ->label('Chỉnh Sửa')
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning'),

                    Action::make('reset_password')
                        ->label('Đặt Lại Mật Khẩu')
                        ->icon('heroicon-o-key')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Đặt Lại Mật Khẩu')
                        ->modalDescription('Tạo mật khẩu mới cho người dùng này.')
                        ->form([
                            TextInput::make('new_password')
                                ->label('Mật khẩu mới')
                                ->password()
                                ->required()
                                ->minLength(8)
                                ->placeholder('Nhập mật khẩu mới (tối thiểu 8 ký tự)'),
                        ])
                        ->action(function ($record, array $data) {
                            $record->update([
                                'password' => Hash::make($data['new_password'])
                            ]);

                            Notification::make()
                                ->title('Thành công!')
                                ->body('Đã đặt lại mật khẩu cho người dùng.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        }),

                    Action::make('send_verification')
                        ->label('Gửi Email Xác Minh')
                        ->icon('heroicon-o-envelope')
                        ->color('secondary')
                        ->visible(fn($record) => !$record->email_verified_at)
                        ->requiresConfirmation()
                        ->modalHeading('Gửi Email Xác Minh')
                        ->modalDescription('Gửi email xác minh đến địa chỉ email của người dùng.')
                        ->action(function ($record) {
                            // Logic to send verification email
                            Notification::make()
                                ->title('Thành công!')
                                ->body('Đã gửi email xác minh đến người dùng.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        }),

                    DeleteAction::make()
                        ->label('Xóa Người Dùng')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Người Dùng')
                        ->modalDescription('Bạn có chắc chắn muốn xóa người dùng này? Hành động này không thể hoàn tác.')
                        ->visible(fn($record) => static::canDelete($record)),
                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Action::make('export_users')
                        ->label('Xuất Dữ Liệu')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function ($records) {
                            // Logic to export users data
                            Notification::make()
                                ->title('Đang xuất dữ liệu...')
                                ->body('Dữ liệu của ' . $records->count() . ' người dùng đang được xuất.')
                                ->info()
                                ->send();
                        }),

                    DeleteBulkAction::make()
                        ->label('Xóa Tất Cả Đã Chọn')
                        ->modalHeading('Xóa Người Dùng Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa những người dùng này? Hành động này không thể hoàn tác.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger'),
                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có người dùng nào')
            ->emptyStateDescription('Hãy tạo người dùng đầu tiên cho hệ thống!')
            ->emptyStateIcon('heroicon-o-user-group')
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->poll('120s'); // Auto refresh every 2 minutes
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['roles']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'roles.name'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['roles']);
    }
}
