<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Unit: string implements HasLabel
{
    case MM = 'mm';
    case CM = 'cm';
    case M = 'm';

    public function getLabel(): string
    {
        return match ($this) {
            self::MM => 'milimetry',
            self::CM => 'centimetry',
            self::M => 'metry',
        };
    }
}
