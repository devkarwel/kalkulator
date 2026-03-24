<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttributeSideColumn: string implements HasLabel
{
    case COLUMN_LEFT = 'column_left';
    case COLUMN_RIGHT = 'column_right';
    case COLUMN_FULL = 'column_full';

    public function getLabel(): string
    {
        return match ($this) {
            self::COLUMN_LEFT => 'Kolumna lewa',
            self::COLUMN_RIGHT => 'Kolumna prawa',
            self::COLUMN_FULL => 'Cała szerokość',
        };
    }
}
