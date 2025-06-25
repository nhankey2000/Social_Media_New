<?php

namespace App\Filament\Resources\YouTubeAccountResource\Pages;

use App\Filament\Resources\YouTubeAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListYouTubeAccounts extends ListRecords
{
    protected static string $resource = YouTubeAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
