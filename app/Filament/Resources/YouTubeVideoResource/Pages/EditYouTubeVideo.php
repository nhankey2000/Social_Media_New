<?php

namespace App\Filament\Resources\YouTubeVideoResource\Pages;

use App\Filament\Resources\YouTubeVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYouTubeVideo extends EditRecord
{
    protected static string $resource = YouTubeVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
