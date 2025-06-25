<?php

namespace App\Filament\Resources;

use App\Filament\Resources\YouTubeAccountResource\Pages;
use App\Models\PlatformAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class YouTubeAccountResource extends Resource
{
    protected static ?string $model = PlatformAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-play';
    protected static ?string $navigationGroup = 'Tài khoản';
    protected static ?string $label = 'YouTube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên tài khoản')
                    ->required(),

                Forms\Components\TextInput::make('app_id')
                    ->label('Client ID')
                    ->required(),

                Forms\Components\TextInput::make('app_secret')
                    ->label('Client Secret')
                    ->required(),

                Forms\Components\TextInput::make('redirect_uri')
                    ->label('Redirect URI')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Tên tài khoản')->searchable(),
                Tables\Columns\TextColumn::make('app_id')->label('Client ID')->copyable()->limit(30),
                Tables\Columns\TextColumn::make('access_token')->label('Access Token')->limit(20)->copyable(),
                Tables\Columns\TextColumn::make('expires_at')->label('Hết hạn')->since()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Tạo lúc')->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label('Cập nhật')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Xác thực Google')
                    ->button()
                    ->icon('heroicon-o-link')
                    ->url(fn ($record) => route('youtube.auth', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouTubeAccounts::route('/'),
            'create' => Pages\CreateYouTubeAccount::route('/create'),
            'edit' => Pages\EditYouTubeAccount::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('platform','YouTube');
    }
}
