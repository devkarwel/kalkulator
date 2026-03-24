<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PriceActionModifier: string implements HasLabel
{
    case ADD = 'add';
    case SUBTRACT = 'subtract';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADD => 'dolicz',
            self::SUBTRACT => 'odlicz',
        };
    }
}
