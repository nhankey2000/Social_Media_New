<?php

namespace App\Filament\Resources\ImagesDataResource\Pages;

use App\Filament\Resources\ImagesDataResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateImagesData extends CreateRecord
{
    protected static string $resource = ImagesDataResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $files = $data['files'] ?? [];
        $type = $data['type'];

        // Tạo record đầu tiên (để return)
        $firstRecord = null;

        if (!empty($files)) {
            foreach ($files as $filePath) {
                $record = static::getModel()::create([
                    'post_id' => null,
                    'type' => $type,
                    'url' => Storage::url($filePath),
                ]);

                // Lưu record đầu tiên để return
                if (!$firstRecord) {
                    $firstRecord = $record;
                }
            }
        }

        return $firstRecord ?: static::getModel()::create([
            'post_id' => null,
            'type' => $type,
            'url' => null,
        ]);
    }
}
