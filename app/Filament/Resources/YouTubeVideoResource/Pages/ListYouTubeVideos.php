<?php

namespace App\Filament\Resources\YouTubeVideoResource\Pages;

use App\Filament\Resources\YouTubeVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYouTubeVideos extends ListRecords
{
    protected static string $resource = YouTubeVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
