<?php

namespace App\Filament\Resources\DataPostResource\Pages;

use App\Filament\Resources\DataPostResource;
use App\Models\DataPost;
use App\Models\ImagesData;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class CreateDataPost extends CreateRecord
{
    protected static string $resource = DataPostResource::class;

    protected function handleRecordCreation(array $data): DataPost
    {
        $files = $data['files'] ?? [];

        // Remove files từ data để tạo DataPost
        unset($data['files']);
        unset($data['existing_files']);

        // Tạo DataPost record
        $post = DataPost::create($data);

        // Lưu files vào bảng ImagesData
        if (!empty($files)) {
            $createdFiles = 0;
            foreach ($files as $file) {
                ImagesData::create([
                    'post_id' => $post->id,
                    'type' => $post->type,
                    'id_danhmuc_data' => $post->id_danhmuc_data,
                    'url' => Storage::url($file),
                    'created_at' => now(),
                ]);
                $createdFiles++;
            }

            // Gửi notification thành công
            Notification::make()
                ->title('Thành công')
                ->body("Đã tạo post và lưu {$createdFiles} file vào thư viện.")
                ->success()
                ->send();
        }

        return $post;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
