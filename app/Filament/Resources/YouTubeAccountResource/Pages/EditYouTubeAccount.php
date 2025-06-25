<?php

namespace App\Filament\Resources\YouTubeAccountResource\Pages;

use App\Filament\Resources\YouTubeAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYouTubeAccount extends EditRecord
{
    protected static string $resource = YouTubeAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
