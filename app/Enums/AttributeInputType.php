<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttributeInputType: string implements HasLabel
{
    case FIELD_INPUT = 'field_input';
    case SELECT_INPUT = 'select_input';
    case ONLY_IMAGE = 'graphic';
    case ONLY_TEXT = 'textarea';
    case COLLECTION = 'collection';

    public function getLabel(): string
    {
        return match ($this) {
            self::FIELD_INPUT => __('Pole tekstowe'),
            self::SELECT_INPUT => __('Pole wyboru'),
            self::ONLY_IMAGE => __('Grafika'),
            self::ONLY_TEXT => __('Tekst'),
            self::COLLECTION => __('Kolekcja'),
        };
    }
}
