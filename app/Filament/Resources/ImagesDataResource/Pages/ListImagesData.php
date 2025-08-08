<?php

namespace App\Filament\Resources\ImagesDataResource\Pages;

use App\Filament\Resources\ImagesDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImagesData extends ListRecords
{
    protected static string $resource = ImagesDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
