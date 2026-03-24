<?php

namespace App\Filament\Admin\Resources\ProductCollectionResource\Pages;

use App\Filament\Admin\Resources\ProductCollectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductCollections extends ListRecords
{
    protected static string $resource = ProductCollectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
