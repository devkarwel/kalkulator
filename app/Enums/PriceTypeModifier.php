<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PriceTypeModifier: string implements HasLabel
{
    case AMOUNT = 'amount';
    case PERCENT = 'percent';

    public function getLabel(): string
    {
        return match ($this) {
            self::AMOUNT => 'kwota',
            self::PERCENT => 'procent',
        };
    }
}
