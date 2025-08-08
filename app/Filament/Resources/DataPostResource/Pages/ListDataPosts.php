<?php
// App\Filament\Resources\DataPostResource\Pages\ListDataPosts.php

namespace App\Filament\Resources\DataPostResource\Pages;

use App\Filament\Resources\DataPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDataPosts extends ListRecords
{
    protected static string $resource = DataPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
