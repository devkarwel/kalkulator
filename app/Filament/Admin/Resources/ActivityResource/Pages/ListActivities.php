<?php

namespace App\Filament\Admin\Resources\ActivityResource\Pages;

use App\Filament\Admin\Resources\ActivityResource;
use Filament\Resources\Pages\ListRecords;

class ListActivities extends ListRecords
{
    protected static string $resource = ActivityResource::class;
    protected static ?string $title = 'Historia aktywności';

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
