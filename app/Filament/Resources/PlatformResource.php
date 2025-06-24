<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlatformResource\Pages;
use App\Models\Platform;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class PlatformResource extends Resource
{
    protected static ?string $model = Platform::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Quản Lý Tài Khoản';
    protected static ?string $label = 'Nền Tảng';
    protected static ?string $pluralLabel = 'Nền Tảng';

//    public static function canViewAny(): bool
//    {
//        return Auth::user()->role === 'admin';
//    }

//    public static function shouldRegisterNavigation(): bool
//    {
//        return Auth::user()->role === 'admin';
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section: Platform Information
                Forms\Components\Section::make('Thông Tin Nền Tảng')
                    ->description('Nhập thông tin chi tiết về nền tảng.')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                // Platform name
                                Forms\Components\TextInput::make('name')
                                    ->label('Tên Nền Tảng')
                                    ->required()
                                    ->maxLength(255)
                                    ->extraAttributes(['class' => 'bg-gray-800 text-gray-300']),
                                // Logo upload
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Nền Tảng')
                                    ->image() // Chỉ cho phép upload file ảnh
                                    ->directory('platform-logos') // Thư mục lưu trữ ảnh
                                    ->disk('public') // Sử dụng disk public
                                    ->nullable()
                                    ->maxSize(1024) // Giới hạn kích thước file (1MB)
                                    ->extraAttributes(['class' => 'bg-gray-800 text-gray-300']),
                            ]),
                    ])
                    ->collapsible()
                    ->extraAttributes(['class' => 'bg-gray-900 border border-gray-700']),
            ]);
    }

    /**
     * Define the table schema for displaying Platforms.
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên Nền Tảng')
                    ->searchable()
                    ->extraAttributes(['class' => 'font-semibold text-gray-200']),
                // Thêm cột hiển thị ảnh logo
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->getStateUsing(function ($record) {
                        if ($record->logo) {
                            return asset('storage/' . $record->logo); // Đảm bảo đường dẫn đúng
                        }
                        return null;
                    })
                    ->circular() // Tùy chọn: làm ảnh tròn
                    ->extraAttributes(['class' => 'w-12 h-12 text-gray-400']), // Định kích thước ảnh
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->extraAttributes(['class' => 'text-gray-400']),
                // Cột debug để kiểm tra đường dẫn
                Tables\Columns\TextColumn::make('logo_debug')
                    ->label('Debug Logo')
                    ->getStateUsing(function ($record) {
                        return $record->logo ? asset('storage/' . $record->logo) : 'No logo';
                    })
                    ->visible(false), // Ẩn cột này sau khi debug xong
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Sửa')
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Tất Cả')
                        ->modalHeading('Xóa Các Nền Tảng Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các nền tảng này? Hành động này sẽ không thể hoàn tác.')
                        ->modalButton('Xác Nhận')
                        ->color('danger'),
                ])->label('Tùy Chọn'),
            ]);
    }

    /**
     * Define the pages for the Platform resource.
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlatforms::route('/'),
            'create' => Pages\CreatePlatform::route('/create'),
            'edit' => Pages\EditPlatform::route('/{record}/edit'),
        ];
    }
}
