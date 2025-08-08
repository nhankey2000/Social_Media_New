<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPostResource\Pages;
use App\Models\DataPost;
use App\Models\ImagesData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DataPostResource extends Resource
{
    protected static ?string $model = DataPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Data Posts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('type')
                    ->options([
                        'video' => 'Video',
                        'image' => 'Image',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(5),

                Forms\Components\FileUpload::make('images')
                    ->label('Upload Images')
                    ->image()
                    ->multiple()
                    ->directory('data-post-images')
                    ->disk('public')
                    ->maxFiles(10)
                    ->reorderable()
                    ->helperText('Upload up to 10 images')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => 'video',
                        'success' => 'image',
                    ]),

                Tables\Columns\TextColumn::make('content')
                    ->limit(50),

                Tables\Columns\TextColumn::make('imagesData_count')
                    ->counts('imagesData')
                    ->label('Images')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'video' => 'Video',
                        'image' => 'Image',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDataPosts::route('/'),
            'create' => Pages\CreateDataPost::route('/create'),
            'edit' => Pages\EditDataPost::route('/{record}/edit'),
        ];
    }

    // Custom methods để xử lý ảnh
    public static function handleImagesSave($record, $images)
    {
        if (!empty($images)) {
            foreach ($images as $imagePath) {
                ImagesData::create([
                    'post_id' => $record->id,
                    'type' => $record->type,
                    'url' => Storage::url($imagePath),
                    'created_at' => now(),
                ]);
            }
        }
    }

    public static function handleImagesUpdate($record, $images)
    {
        // Xóa ảnh cũ
        ImagesData::where('post_id', $record->id)->delete();

        // Lưu ảnh mới
        if (!empty($images)) {
            foreach ($images as $imagePath) {
                ImagesData::create([
                    'post_id' => $record->id,
                    'type' => $record->type,
                    'url' => Storage::url($imagePath),
                    'created_at' => now(),
                ]);
            }
        }
    }

    public static function getExistingImages($record)
    {
        return ImagesData::where('post_id', $record->id)
            ->pluck('url')
            ->map(function ($url) {
                return str_replace(Storage::url(''), '', $url);
            })
            ->toArray();
    }
}
