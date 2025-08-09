<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataPostResource\Pages;
use App\Models\DataPost;
use App\Models\ImagesData;
use App\Models\DanhmucData;
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
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn (callable $set) => $set('files', [])),

                Forms\Components\Select::make('id_danhmuc_data')
                    ->label('Danh mục')
                    ->options(DanhmucData::pluck('ten_danh_muc', 'id'))
                    ->searchable()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('ten_danh_muc')
                            ->label('Tên danh mục')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->createOptionAction(fn ($action) => $action->modalHeading('Thêm danh mục mới'))
                    ->createOptionUsing(function (array $data) {
                        $danhmuc = DanhmucData::create([
                            'ten_danh_muc' => $data['ten_danh_muc'],
                        ]);
                        return $danhmuc->id;
                    }),

                Forms\Components\Textarea::make('content')
                    ->required()
                    ->rows(5),

                Forms\Components\FileUpload::make('files')
                    ->label('Upload Files')
                    ->multiple()
                    ->directory('data-post-files')
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
                        return [];
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

                // Hidden field để lưu existing files cho edit
                Forms\Components\Hidden::make('existing_files')
                    ->visible(fn (?DataPost $record): bool => $record !== null),
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

                Tables\Columns\TextColumn::make('danhmucData.ten_danh_muc')
                    ->label('Danh mục')
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
                    ->label('Files')
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
                Tables\Filters\SelectFilter::make('id_danhmuc_data')
                    ->label('Danh mục')
                    ->options(DanhmucData::pluck('ten_danh_muc', 'id')),
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

    // Helper methods để xử lý files
    public static function saveFilesToImagesData($post, $files)
    {
        if (!empty($files)) {
            foreach ($files as $file) {
                ImagesData::create([
                    'post_id' => $post->id,
                    'type' => $post->type,
                    'id_danhmuc_data' => $post->id_danhmuc_data,
                    'url' => Storage::url($file),
                    'created_at' => now(),
                ]);
            }
        }
    }

    public static function updateFilesInImagesData($post, $files)
    {
        // Xóa files cũ
        ImagesData::where('post_id', $post->id)->delete();

        // Lưu files mới
        if (!empty($files)) {
            foreach ($files as $file) {
                ImagesData::create([
                    'post_id' => $post->id,
                    'type' => $post->type,
                    'id_danhmuc_data' => $post->id_danhmuc_data,
                    'url' => Storage::url($file),
                    'created_at' => now(),
                ]);
            }
        }
    }

    public static function getExistingFiles($post)
    {
        return ImagesData::where('post_id', $post->id)
            ->pluck('url')
            ->map(function ($url) {
                return str_replace('/storage/', '', $url);
            })
            ->toArray();
    }
}
