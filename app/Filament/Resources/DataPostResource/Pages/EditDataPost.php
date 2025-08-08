<?php
// App\Filament\Resources\DataPostResource\Pages\EditDataPost.php

namespace App\Filament\Resources\DataPostResource\Pages;

use App\Filament\Resources\DataPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPost extends EditRecord
{
    protected static string $resource = DataPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load ảnh hiện tại để hiển thị trong form
        $data['images'] = DataPostResource::getExistingImages($this->record);
        return $data;
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Tách images ra
        $images = $data['images'] ?? [];
        unset($data['images']);

        // Update DataPost
        $record->update($data);

        // Update images trong bảng images_data
        DataPostResource::handleImagesUpdate($record, $images);

        return $record;
    }
}
