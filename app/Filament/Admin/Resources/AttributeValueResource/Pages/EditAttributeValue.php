<?php

namespace App\Filament\Admin\Resources\AttributeValueResource\Pages;

use App\Filament\Admin\Resources\AttributeValueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttributeValue extends EditRecord
{
    protected static string $resource = AttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Powrót')
                ->icon('heroicon-o-arrow-left')
                ->url(function () {
                    $attributeId = $this->record->attribute_id;
                    return AttributeValueResource::getUrl('index', [
                        'tableFilters' => ['attribute_id' => ['value' => $attributeId]]
                    ]);
                })
                ->color('gray'),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }
}

