<?php

namespace App\Filament\Resources\ImagesDataResource\Pages;

use App\Filament\Resources\ImagesDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditImagesData extends EditRecord
{
    protected static string $resource = ImagesDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load file hiện tại để hiển thị trong FileUpload
        if (isset($data['url']) && $data['url']) {
            // Chuyển URL thành file path
            $filePath = str_replace(Storage::url(''), '', $data['url']);
            $data['files'] = [$filePath];
        } else {
            $data['files'] = [];
        }

        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $files = $data['files'] ?? [];

        if (!empty($files)) {
            // Lấy file đầu tiên để update record hiện tại
            $firstFile = $files[0];
            $record->update([
                'type' => $data['type'],
                'url' => Storage::url($firstFile),
            ]);

            // Tạo records mới cho các file còn lại
            for ($i = 1; $i < count($files); $i++) {
                static::getModel()::create([
                    'post_id' => null,
                    'type' => $data['type'],
                    'url' => Storage::url($files[$i]),
                ]);
            }
        } else {
            // Nếu không có file mới, chỉ update type
            $record->update([
                'type' => $data['type'],
            ]);
        }

        return $record;
    }
}
