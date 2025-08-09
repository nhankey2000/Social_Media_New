<?php

namespace App\Filament\Resources\ImagesDataResource\Pages;

use App\Filament\Resources\ImagesDataResource;
use App\Models\ImagesData;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class CreateImagesData extends CreateRecord
{
    protected static string $resource = ImagesDataResource::class;

    protected function handleRecordCreation(array $data): ImagesData
    {
        $files = $data['files'] ?? [];
        $type = $data['type'];
        $idDanhmucData = $data['id_danhmuc_data'];

        if (empty($files)) {
            throw new \Exception('Vui lòng chọn ít nhất một file để upload.');
        }

        $createdRecords = [];

        foreach ($files as $file) {
            $recordData = [
                'type' => $type,
                'id_danhmuc_data' => $idDanhmucData,
                'url' => Storage::url($file),
            ];

            $record = ImagesData::create($recordData);
            $createdRecords[] = $record;
        }

        // Gửi notification thành công
        Notification::make()
            ->title('Thành công')
            ->body('Đã tạo thành công ' . count($createdRecords) . ' bản ghi.')
            ->success()
            ->send();

        // Return record đầu tiên (yêu cầu của Filament)
        return $createdRecords[0] ?? new ImagesData();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
