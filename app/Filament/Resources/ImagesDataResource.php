<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImagesDataResource\Pages;
use App\Models\ImagesData;
use App\Models\DataPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ImagesDataResource extends Resource
{
    protected static ?string $model = ImagesData::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Images Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'video' => 'Video',
                        'image' => 'Image',
                    ])
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (callable $set) => $set('files', [])),

                Forms\Components\FileUpload::make('files')
                    ->label('Upload Files')
                    ->multiple()
                    ->directory('media-files')
                    ->disk('public')
                    ->required()
                    ->maxFiles(20)
                    ->reorderable()
                    ->acceptedFileTypes(function (callable $get) {
                        $type = $get('type');
                        if ($type === 'image') {
                            return ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg'];
                        } elseif ($type === 'video') {
                            return ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/webm'];
                        }
                        return []; // Không cho upload gì nếu chưa chọn type
                    })
                    ->maxSize(function (callable $get) {
                        $type = $get('type');
                        return $type === 'video' ? 204800 : 20480; // 200MB for video, 20MB for image
                    })
                    ->helperText(function (callable $get) {
                        $type = $get('type');
                        if ($type === 'image') {
                            return 'Upload up to 20 images (JPG, PNG, GIF, WebP) - Max 20MB each';
                        } elseif ($type === 'video') {
                            return 'Upload up to 20 videos (MP4, AVI, MOV, WMV, WebM) - Max 200MB each';
                        }
                        return 'Please select a type first to enable file upload';
                    })
                    ->visible(fn (callable $get): bool => !empty($get('type')))
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'video',
                        'success' => 'image',
                    ]),

                Tables\Columns\ImageColumn::make('url')
                    ->label('Preview')
                    ->height(60)
                    ->width(60)
                    ->circular()
                    ->visible(fn ($record) => $record && $record->type === 'image'),

                Tables\Columns\TextColumn::make('url')
                    ->label('File')
                    ->limit(40)
                    ->copyable()
                    ->formatStateUsing(fn ($state) => $state ? basename($state) : 'No file')
                    ->tooltip(fn ($state) => $state),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'video' => 'Video',
                        'image' => 'Image',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => $record->url ? Storage::url(str_replace('/storage/', '', $record->url)) : '#')
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->url)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListImagesData::route('/'),
            'create' => Pages\CreateImagesData::route('/create'),
            'edit' => Pages\EditImagesData::route('/{record}/edit'),
        ];
    }
}
