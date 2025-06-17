<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ImageLibraryResource\Pages;
use App\Models\Category;
use App\Models\ImageLibrary;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Filament\Support\Colors\Color;

class ImageLibraryResource extends Resource
{
    protected static ?string $model = ImageLibrary::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Tự Động Đăng Bài';

    protected static ?string $navigationLabel = 'Thư Viện Media';

    protected static ?string $pluralLabel = 'Thư Viện Media';

    protected static ?string $recordTitleAttribute = 'item';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tải Lên Media Chuyên Nghiệp')
                    ->description('Quản lý thư viện media với hệ thống phân loại thông minh và upload đa dạng')
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->schema([
                        Forms\Components\Grid::make(1)
                            ->schema([
                                // Enhanced Category selection
                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('category_id')
                                        ->label('Danh Mục Media')
                                        ->relationship('category', 'category')
                                        ->required()
                                        ->placeholder('Chọn danh mục cho media của bạn')
                                        ->helperText('Phân loại media giúp quản lý và tìm kiếm dễ dàng hơn')
                                        ->searchable()
                                        ->preload()
                                        ->reactive()
                                        ->extraAttributes([
                                            'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-300 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 font-medium text-gray-800'
                                        ])
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            // Optional: Handle state update if needed
                                        })
                                        ->suffixActions([
                                            Forms\Components\Actions\Action::make('add_category')
                                                ->label('Tạo Danh Mục Mới')
                                                ->icon('heroicon-o-plus-circle')
                                                ->color('success')
                                                ->size('lg')
                                                ->modalHeading('Tạo Danh Mục Media Mới')
                                                ->modalSubmitActionLabel('Tạo Danh Mục')
                                                ->modalCancelActionLabel('Hủy Bỏ')
                                                ->modalWidth('md')
                                                ->form([
                                                    Forms\Components\TextInput::make('category')
                                                        ->label('Tên Danh Mục')
                                                        ->required()
                                                        ->maxLength(255)
                                                        ->placeholder('Ví dụ: Du lịch, Ẩm thực, Sự kiện...')
                                                        ->helperText('Tên danh mục nên ngắn gọn và dễ hiểu')
                                                        ->extraAttributes([
                                                            'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-lg focus:border-green-500 focus:ring-green-200'
                                                        ]),
                                                ])
                                                ->action(function (array $data, $livewire) {
                                                    // Kiểm tra danh mục đã tồn tại
                                                    if (Category::where('category', $data['category'])->exists()) {
                                                        \Filament\Notifications\Notification::make()
                                                            ->title('Danh mục đã tồn tại!')
                                                            ->body('Danh mục "' . $data['category'] . '" đã có trong hệ thống.')
                                                            ->danger()
                                                            ->duration(5000)
                                                            ->send();
                                                        return;
                                                    }

                                                    $category = Category::create([
                                                        'category' => $data['category'],
                                                    ]);

                                                    // Làm mới form và tự động chọn danh mục mới
                                                    $livewire->dispatch('refreshForm');

                                                    \Filament\Notifications\Notification::make()
                                                        ->title('Tạo danh mục thành công!')
                                                        ->body('Danh mục "' . $data['category'] . '" đã được thêm vào hệ thống.')
                                                        ->success()
                                                        ->duration(5000)
                                                        ->send();

                                                    $livewire->form->fill([
                                                        'category_id' => $category->id,
                                                    ]);
                                                }),
                                        ]),
                                ])->extraAttributes([
                                    'class' => 'bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 shadow-sm'
                                ]),

                                // Enhanced Media upload section
                                Forms\Components\Group::make([
                                    Forms\Components\FileUpload::make('media')
                                        ->label('Tải Lên Media')
                                        ->multiple()
                                        ->directory(function ($state) {
                                            $file = $state[0] ?? null;
                                            if ($file && str_starts_with($file->getMimeType(), 'video/')) {
                                                return 'videos';
                                            }
                                            return 'images';
                                        })
                                        ->visibility('public')
                                        ->maxFiles(10)
                                        ->maxSize(102400) // 100MB
                                        ->helperText('Hỗ trợ: JPG, PNG, GIF, MP4, WEBM | Tối đa 10 files, mỗi file 100MB')
                                        ->acceptedFileTypes([
                                            'image/jpeg',
                                            'image/jpg',
                                            'image/png',
                                            'image/gif',
                                            'image/webp',
                                            'video/mp4',
                                            'video/mpeg',
                                            'video/webm',
                                            'video/quicktime'
                                        ])
                                        ->preserveFilenames()
                                        ->imageEditor()
                                        ->imageEditorAspectRatios([
                                            '16:9',
                                            '4:3',
                                            '1:1',
                                            '9:16',
                                            null
                                        ])
                                        ->panelLayout('grid')
                                        ->extraAttributes([
                                            'class' => 'border-4 border-dashed border-purple-300 rounded-2xl bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 hover:border-purple-400 hover:bg-gradient-to-br hover:from-purple-100 hover:via-pink-100 hover:to-blue-100 transition-all duration-500'
                                        ])
                                        ->saveUploadedFileUsing(function ($state, $get) {
                                            \Illuminate\Support\Facades\Log::info('Media FileUpload state:', [
                                                'state' => $state,
                                                'count' => is_array($state) ? count($state) : 0,
                                                'category_id' => $get('category_id')
                                            ]);

                                            if (!is_array($state) || empty($state)) {
                                                \Illuminate\Support\Facades\Log::warning('No media uploaded or invalid state', ['state' => $state]);
                                                return null;
                                            }

                                            $fileNames = array_map(function ($file) {
                                                return $file instanceof \Illuminate\Http\UploadedFile ? $file->getClientOriginalName() : 'invalid';
                                            }, $state);
                                            $lockKey = 'media_upload_lock_' . md5($get('category_id') . implode('|', $fileNames));

                                            if (\Illuminate\Support\Facades\Cache::has($lockKey)) {
                                                \Illuminate\Support\Facades\Log::warning('Duplicate media submit detected:', [
                                                    'lock_key' => $lockKey,
                                                    'files' => $fileNames
                                                ]);
                                                return null;
                                            }

                                            \Illuminate\Support\Facades\Cache::put($lockKey, true, now()->addSeconds(10));

                                            $categoryId = $get('category_id');
                                            foreach ($state as $file) {
                                                if ($file instanceof \Illuminate\Http\UploadedFile) {
                                                    $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';
                                                    $directory = $type === 'video' ? 'videos' : 'images';
                                                    $path = $file->store($directory, 'public');
                                                    \Illuminate\Support\Facades\Log::info('Saving media:', [
                                                        'path' => $path,
                                                        'category_id' => $categoryId,
                                                        'file' => $file->getClientOriginalName(),
                                                        'lock_key' => $lockKey,
                                                        'type' => $type
                                                    ]);
                                                    ImageLibrary::create([
                                                        'category_id' => $categoryId,
                                                        'item' => $path,
                                                        'type' => $type,
                                                        'status' => 'unused',
                                                        'used_at' => null,
                                                    ]);
                                                }
                                            }

                                            return null;
                                        })
                                        ->dehydrated(false),
                                ])->extraAttributes([
                                    'class' => 'bg-gradient-to-br from-purple-50 to-pink-50 border-2 border-purple-200 rounded-2xl p-6 shadow-sm'
                                ]),

                                // Status and metadata section for editing
                                Forms\Components\Group::make([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\Select::make('status')
                                                ->label('Trạng Thái Media')
                                                ->options([
                                                    'unused' => 'Chưa Sử Dụng',
                                                    'used' => 'Đã Sử Dụng',
                                                ])
                                                ->disabled(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                                                ->helperText('Trạng thái sử dụng của media trong hệ thống')
                                                ->extraAttributes([
                                                    'class' => 'bg-gradient-to-r from-green-50 to-emerald-50 border-green-300 rounded-lg focus:border-green-500 focus:ring-green-200'
                                                ]),

                                            Forms\Components\TextInput::make('used_at')
                                                ->label('Thời Gian Sử Dụng')
                                                ->disabled()
                                                ->formatStateUsing(fn ($state) => $state ? $state->format('d/m/Y H:i') : 'Chưa sử dụng')
                                                ->helperText('Thời điểm media được sử dụng lần cuối')
                                                ->extraAttributes([
                                                    'class' => 'bg-gradient-to-r from-gray-50 to-slate-50 border-gray-300 rounded-lg opacity-75'
                                                ]),
                                        ]),
                                ])->visible(fn ($livewire) => !($livewire instanceof \Filament\Resources\Pages\CreateRecord))
                                    ->extraAttributes([
                                        'class' => 'bg-gradient-to-br from-gray-50 to-slate-50 border-2 border-gray-200 rounded-2xl p-6 shadow-sm'
                                    ]),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 border-2 border-indigo-600 rounded-2xl shadow-2xl hover:shadow-indigo-500/25 transition-all duration-500'
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.category')
                    ->label('Danh Mục')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->weight('bold')
                    ->extraAttributes(['class' => 'font-semibold']),

                Tables\Columns\TextColumn::make('type')
                    ->label('Loại Media')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'image' => 'success',
                        'video' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'image' => 'Hình Ảnh',
                        'video' => 'Video',
                        default => Str::title($state),
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'image' => 'heroicon-o-photo',
                        'video' => 'heroicon-o-play-circle',
                        default => 'heroicon-o-document',
                    }),

                Tables\Columns\TextColumn::make('item')
                    ->label('Xem Trước Media')
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        $mediaPath = $state;
                        $mediaType = strtolower($record->type);
                        $mediaUrl = null;
                        $fileExists = false;

                        if (is_string($mediaPath) && !empty($mediaPath)) {
                            $mediaUrl = Storage::disk('public')->url($mediaPath);
                            $fileExists = Storage::disk('public')->exists($mediaPath);
                        }

                        if ($mediaType === 'image' && $mediaUrl && $fileExists) {
                            return '<div class="relative group">
                                        <img src="' . $mediaUrl . '" alt="Preview" class="object-cover rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105" style="width: 80px; height: 80px;">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-xl transition-all duration-300 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </div>
                                    </div>';
                        } elseif ($mediaType === 'video' && $mediaUrl && $fileExists) {
                            return '<div class="relative group">
                                        <video width="80" height="80" class="object-cover rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 group-hover:scale-105" poster="">
                                            <source src="' . $mediaUrl . '" type="video/mp4">
                                        </video>
                                        <div class="absolute inset-0 bg-black bg-opacity-30 rounded-xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                    </div>';
                        } elseif ($mediaUrl && !$fileExists) {
                            return '<div class="flex items-center space-x-2 text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <span class="text-xs">File không tồn tại</span>
                                    </div>';
                        }

                        return '<div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl shadow-sm flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>';
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng Thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unused' => 'success',
                        'used' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unused' => 'Chưa Sử Dụng',
                        'used' => 'Đã Sử Dụng',
                        default => Str::title($state),
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'unused' => 'heroicon-o-check-circle',
                        'used' => 'heroicon-o-clock',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('used_at')
                    ->label('Thời Gian Sử Dụng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Chưa sử dụng')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Kích Thước')
                    ->formatStateUsing(function ($record) {
                        $path = $record->item;
                        if ($path && Storage::disk('public')->exists($path)) {
                            $size = Storage::disk('public')->size($path);
                            return $this->formatBytes($size);
                        }
                        return 'N/A';
                    })
                    ->badge()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Lọc theo Danh Mục')
                    ->relationship('category', 'category')
                    ->multiple()
                    ->preload(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Loại Media')
                    ->options([
                        'image' => 'Hình Ảnh',
                        'video' => 'Video',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Trạng Thái Sử Dụng')
                    ->options([
                        'unused' => 'Chưa Sử Dụng',
                        'used' => 'Đã Sử Dụng',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('created_today')
                    ->label('Tạo hôm nay')
                    ->query(fn($query) => $query->whereDate('created_at', today())),

                Tables\Filters\Filter::make('used_this_month')
                    ->label('Đã sử dụng tháng này')
                    ->query(fn($query) => $query->whereMonth('used_at', now()->month)
                        ->whereYear('used_at', now()->year)),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->modalWidth('4xl'),

                    Tables\Actions\EditAction::make()
                        ->label('Chỉnh Sửa')
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning'),

                    Tables\Actions\Action::make('reuse')
                        ->label('Tái Sử Dụng')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Đặt Lại Trạng Thái Media')
                        ->modalDescription('Media này sẽ được đặt lại thành "Chưa Sử Dụng" và có thể được chọn cho các bài đăng mới.')
                        ->modalSubmitActionLabel('Xác Nhận Tái Sử Dụng')
                        ->modalCancelActionLabel('Hủy Bỏ')
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'unused',
                                'used_at' => null,
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Media đã được đặt lại!')
                                ->body('Media này giờ có thể được sử dụng lại trong các bài đăng mới.')
                                ->success()
                                ->duration(5000)
                                ->send();
                        }),

                    Tables\Actions\Action::make('download')
                        ->label('Tải Xuống')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('primary')
                        ->action(function ($record) {
                            $path = $record->item;
                            if ($path && Storage::disk('public')->exists($path)) {
                                return Storage::disk('public')->download($path);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Lỗi tải xuống!')
                                ->body('File không tồn tại hoặc đã bị xóa.')
                                ->danger()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Media')
                        ->modalDescription('Bạn có chắc chắn muốn xóa media này? Hành động này không thể hoàn tác.')
                        ->before(function ($record) {
                            // Xóa file từ storage khi xóa record
                            if ($record->item && Storage::disk('public')->exists($record->item)) {
                                Storage::disk('public')->delete($record->item);
                            }
                        }),
                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_unused')
                        ->label('Đặt Thành Chưa Sử Dụng')
                        ->icon('heroicon-o-arrow-path')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Đặt Lại Trạng Thái Media')
                        ->modalDescription('Tất cả media đã chọn sẽ được đặt lại thành "Chưa Sử Dụng".')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'unused',
                                    'used_at' => null,
                                ]);
                            });
                            \Filament\Notifications\Notification::make()
                                ->title('Đã cập nhật trạng thái!')
                                ->body('Các media đã chọn giờ có thể được sử dụng lại.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Tất Cả Đã Chọn')
                        ->modalHeading('Xóa Các Media Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các media này? Hành động này sẽ không thể hoàn tác và sẽ xóa cả file từ server.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger')
                        ->before(function ($records) {
                            // Xóa files từ storage
                            $records->each(function ($record) {
                                if ($record->item && Storage::disk('public')->exists($record->item)) {
                                    Storage::disk('public')->delete($record->item);
                                }
                            });
                        }),
                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có media nào trong thư viện')
            ->emptyStateDescription('Hãy tải lên media đầu tiên để bắt đầu xây dựng thư viện của bạn!')
            ->emptyStateIcon('heroicon-o-photo')
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->recordUrl(null)
            ->recordAction(null)
            ->poll('30s'); // Auto refresh every 30 seconds
    }

    private static function formatBytes($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . ' ' . $units[$i];
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
            'index' => Pages\ListImageLibraries::route('/'),
            'create' => Pages\CreateImageLibrary::route('/create'),
            'edit' => Pages\EditImageLibrary::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'unused')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['item', 'category.category'];
    }
}
