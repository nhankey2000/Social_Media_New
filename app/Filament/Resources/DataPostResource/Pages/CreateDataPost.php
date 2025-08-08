<?php
// App\Filament\Resources\DataPostResource\Pages\CreateDataPost.php

namespace App\Filament\Resources\DataPostResource\Pages;

use App\Filament\Resources\DataPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataPost extends CreateRecord
{
    protected static string $resource = DataPostResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Tách images ra
        $images = $data['images'] ?? [];
        unset($data['images']);

        // Tạo DataPost
        $record = static::getModel()::create($data);

        // Lưu images vào bảng images_data
        DataPostResource::handleImagesSave($record, $images);

        return $record;
    }
}
