<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AiPostPromptResource\Pages;
use App\Models\AiPostPrompt;
use App\Models\Platform;
use App\Models\PlatformAccount;
use App\Models\RepeatScheduled;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\IconPosition;

class AiPostPromptResource extends Resource
{
    protected static ?string $model = AiPostPrompt::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Tự Động Đăng Bài';

    protected static ?string $navigationLabel = 'Tạo Bài Đăng Bằng AI';

    protected static ?string $pluralLabel = 'Tạo Bài Đăng Bằng AI';

    protected static ?string $recordTitleAttribute = 'prompt';

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Hidden fields for controlling visibility
            ...self::getVisibilityFields(),

            // Section 1: Content Input với thiết kế gradient đẹp
            Forms\Components\Section::make('Nội Dung Bài Đăng')
                ->description('Cung cấp thông tin chính cho bài đăng tự động của bạn')
                ->icon('heroicon-o-document-text')
                ->schema([
                    // Toggle actions với thiết kế đẹp hơn

                    // Image upload section với thiết kế card đẹp
                    Forms\Components\Group::make([
                        Forms\Components\FileUpload::make('image')
                            ->label('Tải Lên Hình Ảnh')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                            ->maxFiles(1)
                            ->directory('ai-post-images')
                            ->disk('public')
                            ->preserveFilenames()
                            ->dehydrated(true)
                            ->required(fn(callable $get) => $get('show_image_upload'))
                            ->helperText('Tải lên hình ảnh (JPG, PNG, GIF, WebP) để AI tạo nội dung phù hợp')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                                '9:16',
                            ])
                            ->extraAttributes([
                                'class' => 'border-2 border-dashed border-blue-300 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 hover:border-blue-400 transition-all duration-300'
                            ])
                            ->afterStateUpdated(function ($state) {
                                Log::info('Trạng thái FileUpload image', [
                                    'state' => $state,
                                ]);
                            })
                            ->getUploadedFileNameForStorageUsing(function ($file) {
                                $filename = $file->getClientOriginalName();
                                $path = 'ai-post-images/' . $filename;
                                Log::info('Tên file từ FileUpload', [
                                    'filename' => $filename,
                                    'path' => $path,
                                ]);
                                return $path;
                            })
                            ->validationMessages([
                                'required' => 'Vui lòng tải lên một hình ảnh.',
                                'image' => 'File tải lên phải là hình ảnh hợp lệ.',
                            ]),

                        Forms\Components\Actions::make([
                            Action::make('show_prompt')
                                ->label('Chuyển sang nhập prompt')
                                ->icon('heroicon-o-document-text')
                                ->color('primary')
                                ->size('sm')
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300'
                                ])
                                ->action(fn(callable $set) => $set('show_prompt', true) && $set('show_image_upload', false)),
                        ])->extraAttributes(['class' => 'flex justify-center mt-4']),
                    ])->visible(fn(callable $get) => $get('show_image_upload')),

                    // Prompt textarea với thiết kế đẹp
                    Forms\Components\Group::make([
                        Forms\Components\Textarea::make('prompt')
                            ->label('Yêu Cầu Đầu Vào Cho AI')
                            ->required()
                            ->rows(6)
                            ->placeholder('Ví dụ: Viết một bài đăng về xu hướng công nghệ AI mới nhất, giọng điệu thân thiện, dài khoảng 200 từ...')
                            ->extraAttributes([
                                'class' => 'bg-gradient-to-br from-gray-50 to-blue-50 border-2 border-blue-200 rounded-xl focus:border-blue-400 focus:ring-4 focus:ring-blue-100 font-medium text-gray-800 placeholder-gray-500 resize-none transition-all duration-300'
                            ])
                            ->helperText('Mô tả chi tiết những gì bạn muốn AI tạo ra để có kết quả tốt nhất'),

                        Forms\Components\Actions::make([
                            Action::make('show_image_upload_alt')
                                ->label('Chuyển Sang Tải Ảnh')
                                ->icon('heroicon-o-photo')
                                ->color('warning')
                                ->size('sm')
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 text-white font-medium py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300'
                                ])
                                ->action(function (callable $set) {
                                    $set('show_prompt', false);
                                    $set('show_image_upload', true);
                                }),
                        ])->extraAttributes(['class' => 'flex justify-center mt-4']),
                    ])->visible(fn(callable $get) => $get('show_prompt')),
                ])
                ->collapsible()
                ->collapsed(false)
                ->extraAttributes([
                    'class' => 'bg-gradient-to-br from-blue-900 via-purple-900 to-pink-900 border-2 border-blue-600 rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-500'
                ]),

            // Section 2: Image Settings với thiết kế card modern
            Forms\Components\Section::make('Cài Đặt Hình Ảnh Nâng Cao')
                ->description('Tùy chỉnh hình ảnh đi kèm để tăng sức hút cho bài đăng')
                ->icon('heroicon-o-adjustments-horizontal')
                ->schema([
                    Forms\Components\Repeater::make('image_settings')
                        ->label('Cấu Hình Hình Ảnh')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\Select::make('image_category')
                                        ->label('Phân Loại Hình Ảnh')
                                        ->options(\App\Models\Category::pluck('category', 'id'))
                                        ->nullable()
                                        ->searchable()
                                        ->preload()
                                        ->extraAttributes([
                                            'class' => 'bg-gradient-to-r from-green-50 to-blue-50 border-green-300 rounded-lg focus:border-green-500 focus:ring-green-200'
                                        ])
                                        ->helperText('Chọn danh mục phù hợp với nội dung bài đăng'),

                                    Forms\Components\TextInput::make('image_count')
                                        ->label('Số Lượng Ảnh Random')
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(10)
                                        ->nullable()
                                        ->suffix('ảnh')
                                        ->extraAttributes([
                                            'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-purple-300 rounded-lg focus:border-purple-500 focus:ring-purple-200'
                                        ])
                                        ->helperText('Số ảnh sẽ được chọn ngẫu nhiên khi đăng bài'),
                                ]),
                        ])
                        ->createItemButtonLabel('Thêm Cài Đặt Mới')
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string =>
                        isset($state['image_category'])
                            ? 'Cài đặt: ' . (\App\Models\Category::find($state['image_category'])['category'] ?? 'Chưa chọn')
                            : 'Cài đặt mới'
                        )
                        ->extraAttributes([
                            'class' => 'bg-gradient-to-r from-gray-50 to-blue-50 border-2 border-blue-200 rounded-xl shadow-sm'
                        ])
                        ->addActionLabel('Thêm Cấu Hình Mới'),
                ])
                ->collapsible()
                ->extraAttributes([
                    'class' => 'bg-gradient-to-br from-green-900 via-teal-900 to-blue-900 border-2 border-green-600 rounded-2xl shadow-2xl hover:shadow-green-500/25 transition-all duration-500'
                ]),

            // Section 3: Enhanced Scheduling Settings
            Forms\Components\Section::make('Lên Lịch Đăng Bài Thông Minh')
                ->description('Thiết lập thời gian đăng và lịch chạy lại một cách chi tiết')
                ->icon('heroicon-o-clock')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\DateTimePicker::make('scheduled_at')
                                ->label('Thời Điểm Lên Lịch')
                                ->nullable()
                                ->displayFormat('d/m/Y H:i')
                                ->native(false)
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-indigo-50 to-purple-50 border-indigo-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-200'
                                ])
                                ->helperText('Chọn thời điểm chính xác để bài đăng được xuất bản'),

                            Forms\Components\DateTimePicker::make('posted_at')
                                ->label('Thời Điểm Đã Đăng')
                                ->nullable()
                                ->disabled()
                                ->displayFormat('d/m/Y H:i')
                                ->extraAttributes([
                                    'class' => 'bg-gray-100 border-gray-300 rounded-lg opacity-75'
                                ])
                                ->helperText('Sẽ tự động cập nhật khi bài đăng được xuất bản'),
                        ]),

                    Forms\Components\Repeater::make('repeatSchedules')
                        ->label('Lịch Chạy Lại Tự Động')
                        ->relationship('repeatSchedules')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\DateTimePicker::make('schedule')
                                        ->label('Thời Điểm Chạy Lại')
                                        ->required()
                                        ->displayFormat('d/m/Y H:i')
                                        ->native(false)
                                        ->extraAttributes([
                                            'class' => 'bg-gradient-to-r from-yellow-50 to-orange-50 border-yellow-300 rounded-lg focus:border-yellow-500 focus:ring-yellow-200'
                                        ]),
                                    Forms\Components\TextInput::make('facebook_post_id')
                                        ->label('Facebook Post ID')
                                        ->disabled()
                                        ->nullable()
                                        ->extraAttributes([
                                            'class' => 'bg-gray-100 border-gray-300 rounded-lg opacity-75 font-mono text-sm'
                                        ])
                                        ->helperText('Tự động tạo khi đăng bài'),
                                ]),
                        ])
                        ->createItemButtonLabel('Thêm Lịch Chạy Lại')
                        ->nullable()
                        ->helperText('Thiết lập nhiều thời điểm để tăng tương tác cho bài đăng')
                        ->mutateRelationshipDataBeforeFillUsing(fn($data, $record) => [
                            'schedule' => $data['schedule'],
                            'facebook_post_id' => $data['facebook_post_id'],
                        ])
                        ->mutateRelationshipDataBeforeSaveUsing(fn($data, $record) => [
                            'schedule' => $data['schedule'],
                            'post_option' => $record->post_option,
                            'selected_pages' => $record->selected_pages,
                            'facebook_post_id' => $data['facebook_post_id'] ?? null,
                        ])
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string =>
                        isset($state['schedule'])
                            ? 'Lặp lại: ' . $state['schedule']
                            : 'Lịch chạy lại mới'
                        )
                        ->deleteAction(fn(Action $action) => $action->color('danger')->icon('heroicon-o-trash')),
                ])
                ->collapsible()
                ->extraAttributes([
                    'class' => 'bg-gradient-to-br from-orange-900 via-red-900 to-pink-900 border-2 border-orange-600 rounded-2xl shadow-2xl hover:shadow-orange-500/25 transition-all duration-500'
                ]),

            // Section 4: Enhanced Platform Settings
            Forms\Components\Section::make('Cài Đặt Nền Tảng Đăng Bài')
                ->description('Chọn nền tảng và các trang để tối ưu hiệu quả đăng bài')
                ->icon('heroicon-o-globe-alt')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('platform_id')
                                ->label('Nền Tảng Đăng Bài')
                                ->relationship('platform', 'name')
                                ->preload()
                                ->searchable()
                                ->nullable()
                                ->reactive()
                                ->afterStateUpdated(fn(callable $set) => $set('post_option', null) && $set('selected_pages', []))
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-300 rounded-lg focus:border-blue-500 focus:ring-blue-200'
                                ])
                                ->helperText('Chọn nền tảng mạng xã hội để đăng bài'),

                            Forms\Components\Select::make('post_option')
                                ->label('Tùy Chọn Đăng Bài')
                                ->options([
                                    'all' => 'Đăng tất cả trang',
                                    'selected' => 'Chọn trang cụ thể',
                                ])
                                ->reactive()
                                ->nullable()
                                ->afterStateUpdated(fn(callable $set) => $set('selected_pages', []))
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-purple-50 to-pink-50 border-purple-300 rounded-lg focus:border-purple-500 focus:ring-purple-200'
                                ])
                                ->helperText('Chọn cách thức đăng bài lên các trang'),
                        ]),

                    Forms\Components\CheckboxList::make('selected_pages')
                        ->label('Chọn Các Trang Cụ Thể')
                        ->options(function (callable $get) {
                            $platformId = $get('platform_id');
                            return $platformId
                                ? PlatformAccount::where('platform_id', $platformId)
                                    ->where('is_active', true)
                                    ->pluck('name', 'id')
                                    ->toArray()
                                : [];
                        })
                        ->visible(fn(callable $get) => $get('post_option') === 'selected')
                        ->required(fn(callable $get) => $get('post_option') === 'selected')
                        ->validationMessages([
                            'required' => 'Vui lòng chọn ít nhất một trang để đăng bài.',
                        ])
                        ->helperText('Chọn các trang phù hợp với nội dung bài đăng')
                        ->columns(2)
                        ->extraAttributes([
                            'class' => 'bg-gradient-to-r from-green-50 to-teal-50 border-2 border-green-200 rounded-xl p-4'
                        ]),
                ])
                ->collapsible()
                ->extraAttributes([
                    'class' => 'bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-900 border-2 border-indigo-600 rounded-2xl shadow-2xl hover:shadow-indigo-500/25 transition-all duration-500'
                ]),

            // Section 5: Enhanced Status and Generated Content
            Forms\Components\Section::make('Trạng Thái và Nội Dung Được Tạo')
                ->description('Theo dõi tiến trình và xem nội dung AI đã tạo')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('status')
                                ->label('Trạng Thái Hiện Tại')
                                ->options([
                                    'pending' => 'Chờ xử lý',
                                    'generating' => 'Đang tạo nội dung',
                                    'generated' => 'Đã tạo nội dung',
                                    'posted' => 'Đã đăng thành công',
                                ])
                                ->default('pending')
                                ->required()
                                ->disabled()
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-r from-gray-100 to-blue-100 border-gray-300 rounded-lg opacity-75'
                                ]),

                            Forms\Components\Textarea::make('generated_content')
                                ->label('Nội Dung AI Đã Sinh Ra')
                                ->rows(8)
                                ->nullable()
                                ->disabled()
                                ->extraAttributes([
                                    'class' => 'bg-gradient-to-br from-gray-800 to-gray-900 text-green-300 border-gray-600 rounded-xl font-mono text-sm leading-relaxed shadow-inner'
                                ])
                                ->helperText('Nội dung được AI tạo ra dựa trên yêu cầu của bạn'),
                        ]),
                ])
                ->collapsible()
                ->extraAttributes([
                    'class' => 'bg-gradient-to-br from-gray-900 via-slate-900 to-zinc-900 border-2 border-gray-600 rounded-2xl shadow-2xl hover:shadow-gray-500/25 transition-all duration-500'
                ]),
        ])->columns(1);
    }

    protected static function getVisibilityFields(): array
    {
        return [
            Forms\Components\Hidden::make('show_prompt')
                ->default(true)
                ->reactive()
                ->dehydrated(false),
            Forms\Components\Hidden::make('show_image_upload')
                ->default(false)
                ->reactive()
                ->dehydrated(false),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('prompt')
                    ->label('Yêu cầu đầu vào')
                    ->limit(40)
                    ->tooltip(fn($record) => $record->prompt)
                    ->default('Được tạo bằng hình ảnh')
                    ->extraAttributes(['class' => 'font-medium text-gray-800'])
                    ->badge()
                    ->color('primary'),

                Tables\Columns\TextColumn::make('image_settings')
                    ->label('Cài Đặt Hình Ảnh')
                    ->limit(30)
                    ->formatStateUsing(function ($state, $record) {
                        $imageSettings = $record->image_settings ?? [];
                        if (empty($imageSettings)) {
                            return 'Chưa chọn';
                        }

                        return collect($imageSettings)
                            ->map(function ($setting) {
                                $categoryId = $setting['image_category'] ?? null;
                                $count = $setting['image_count'] ?? null;
                                $categoryName = $categoryId
                                    ? \App\Models\Category::find($categoryId)['category'] ?? 'N/A'
                                    : 'Chưa chọn';
                                return $count ? "$categoryName: $count" : null;
                            })
                            ->filter()
                            ->join(', ');
                    })
                    ->badge()
                    ->color('success'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ xử lý',
                        'generating' => 'Đang tạo',
                        'generated' => 'Đã tạo',
                        'posted' => 'Đã đăng',
                    ])
                    ->sortable()
                    ->disabled()
                    ->extraAttributes(['class' => 'font-semibold']),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Người Lên Lịch')
                    ->sortable()
                    ->searchable()
                    ->default('Không xác định')
                    ->formatStateUsing(fn($record) => $record->user ? $record->user->name : 'Không xác định')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Lịch đăng')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('platform.name')
                    ->label('Nền tảng')
                    ->sortable()
                    ->badge()
                    ->color('secondary')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Lọc theo trạng thái')
                    ->options([
                        'pending' => 'Chờ xử lý',
                        'generating' => 'Đang tạo nội dung',
                        'generated' => 'Đã tạo nội dung',
                        'posted' => 'Đã đăng',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('platform_id')
                    ->label('Lọc theo nền tảng')
                    ->relationship('platform', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('scheduled_today')
                    ->label('Lịch hôm nay')
                    ->query(fn($query) => $query->whereDate('scheduled_at', today())),

                Tables\Filters\Filter::make('has_image')
                    ->label('Có hình ảnh')
                    ->query(fn($query) => $query->whereNotNull('image')),

                Tables\Filters\Filter::make('created_this_week')
                    ->label('Tạo tuần này')
                    ->query(fn($query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Xem Chi Tiết')
                        ->icon('heroicon-o-eye')
                        ->color('info')
                        ->slideOver()
                        ->modalWidth('4xl'),

                    Tables\Actions\EditAction::make()
                        ->label('Chỉnh Sửa')
                        ->icon('heroicon-o-pencil-square')
                        ->color('warning'),

                    Tables\Actions\Action::make('duplicate')
                        ->label('Sao Chép')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Sao Chép Bài Đăng AI')
                        ->modalDescription('Tạo một bản sao của bài đăng này với các thiết lập tương tự.')
                        ->action(function ($record) {
                            $newRecord = $record->replicate();
                            $newRecord->status = 'pending';
                            $newRecord->scheduled_at = null;
                            $newRecord->posted_at = null;
                            $newRecord->generated_content = null;
                            $newRecord->save();

                            \Filament\Notifications\Notification::make()
                                ->title('Sao chép thành công!')
                                ->body('Đã tạo bản sao của bài đăng.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\Action::make('regenerate')
                        ->label('Tạo Lại Nội Dung')
                        ->icon('heroicon-o-arrow-path')
                        ->color('primary')
                        ->requiresConfirmation()
                        ->modalHeading('Tạo Lại Nội Dung AI')
                        ->modalDescription('Xóa nội dung hiện tại và yêu cầu AI tạo lại nội dung mới.')
                        ->visible(fn($record) => in_array($record->status, ['generated', 'posted']))
                        ->action(function ($record) {
                            $record->update([
                                'status' => 'pending',
                                'generated_content' => null
                            ]);

                            \Filament\Notifications\Notification::make()
                                ->title('Đã đặt lại!')
                                ->body('Bài đăng sẽ được AI tạo lại nội dung.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteAction::make()
                        ->label('Xóa')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Xóa Bài Đăng AI')
                        ->modalDescription('Bạn có chắc chắn muốn xóa bài đăng này? Hành động này không thể hoàn tác.'),
                ])->tooltip('Tùy chọn')
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_pending')
                        ->label('Đặt Thành Chờ Xử Lý')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->modalHeading('Đặt Lại Trạng Thái')
                        ->modalDescription('Tất cả bài đăng được chọn sẽ được đặt lại thành "Chờ xử lý".')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update([
                                    'status' => 'pending',
                                    'generated_content' => null
                                ]);
                            });
                            \Filament\Notifications\Notification::make()
                                ->title('Đã cập nhật trạng thái!')
                                ->body('Các bài đăng đã được đặt lại thành "Chờ xử lý".')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('schedule_bulk')
                        ->label('Lên Lịch Hàng Loạt')
                        ->icon('heroicon-o-calendar')
                        ->color('primary')
                        ->form([
                            Forms\Components\DateTimePicker::make('scheduled_at')
                                ->label('Thời Điểm Lên Lịch')
                                ->required()
                                ->native(false)
                                ->displayFormat('d/m/Y H:i'),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update([
                                    'scheduled_at' => $data['scheduled_at']
                                ]);
                            });
                            \Filament\Notifications\Notification::make()
                                ->title('Lên lịch thành công!')
                                ->body('Đã lên lịch cho ' . $records->count() . ' bài đăng.')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xoá Tất Cả Đã Chọn')
                        ->modalHeading('Xoá Các Bài Đăng Đã Chọn')
                        ->modalSubheading('Bạn có chắc chắn muốn xoá các bài đăng này? Hành động này sẽ không thể hoàn tác.')
                        ->modalButton('Xác Nhận Xóa')
                        ->color('danger'),
                ])->label('Hành Động Hàng Loạt'),
            ])
            ->emptyStateHeading('Chưa có bài đăng AI nào')
            ->emptyStateDescription('Hãy tạo bài đăng AI đầu tiên của bạn để bắt đầu!')
            ->emptyStateIcon('heroicon-o-sparkles')
            ->striped()
            ->defaultSort('scheduled_at', 'desc')
            ->recordUrl(null)
            ->poll('60s') // Auto refresh every 60 seconds
            ->modifyQueryUsing(function ($query) {
                return $query->orderByRaw('
                    CASE
                        WHEN scheduled_at IS NULL THEN 1
                        ELSE 0
                    END,
                    scheduled_at DESC,
                    created_at DESC
                ');
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAiPostPrompts::route('/'),
            'create' => Pages\CreateAiPostPrompt::route('/create'),
            'edit' => Pages\EditAiPostPrompt::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getGlobalSearchEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user', 'platform']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['prompt', 'generated_content', 'user.name', 'platform.name'];
    }

    public static function getWidgets(): array
    {
        return [
            // Add widgets here if needed
        ];
    }
}
