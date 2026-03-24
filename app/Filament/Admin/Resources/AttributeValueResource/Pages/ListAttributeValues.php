<?php

namespace App\Filament\Admin\Resources\AttributeValueResource\Pages;

use App\Filament\Admin\Resources\AttributeValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAttributeValues extends ListRecords
{
    protected static string $resource = AttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->withCount('priceModifiers');
    }
}

