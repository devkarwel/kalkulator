<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttributeInputVariant: string implements HasLabel
{
    case SELECT_IMAGE_RECTANGLE = 'select_image_rectangle';
    case SELECT_IMAGE_SQUARE = 'select_image_square';
    case SELECT_IMAGE_SQUARE_SMALL = 'select_image_square_small';
    case SELECT_IMAGE_CIRCLE = 'select_image_circle';
    case SELECT_IMAGE_ICON = 'select_image_icon';
    case SELECT_TEXT = 'select_text';
    case INPUT_TEXT = 'input_text';
    case INPUT_NUMBER = 'input_number';
    case NONE = 'none';

    public function getLabel(): string
    {
        return match ($this) {
            self::INPUT_TEXT => 'Pole tekstowe',
            self::INPUT_NUMBER => 'Pole liczbowe',
            self::SELECT_IMAGE_RECTANGLE => 'Pole wyboru - prostokąt',
            self::SELECT_IMAGE_SQUARE => 'Pole wyboru - kwadrat',
            self::SELECT_IMAGE_SQUARE_SMALL => 'Pole wyboru - mały kwadrat',
            self::SELECT_IMAGE_CIRCLE => 'Pole wyboru - okrągłe',
            self::SELECT_IMAGE_ICON => 'Pole wyboru - ikona',
            self::SELECT_TEXT => 'Pole wyboru - tekst',
            self::NONE => 'brak',
        };
    }

    private static function variantsForType(?AttributeInputType $type = null): array
    {
        return match ($type) {
            AttributeInputType::FIELD_INPUT => [
                self::INPUT_TEXT,
                self::INPUT_NUMBER,
            ],

            AttributeInputType::SELECT_INPUT => [
                self::SELECT_IMAGE_RECTANGLE,
                self::SELECT_IMAGE_SQUARE,
                self::SELECT_IMAGE_SQUARE_SMALL,
                self::SELECT_IMAGE_CIRCLE,
                self::SELECT_IMAGE_ICON,
                self::SELECT_TEXT,
            ],

            AttributeInputType::COLLECTION => [
                self::SELECT_IMAGE_RECTANGLE,
                self::SELECT_IMAGE_SQUARE,
                self::SELECT_IMAGE_CIRCLE,
            ],

            default => [
                self::NONE,
            ],
        };
    }

    public static function optionsForInputType(?AttributeInputType $inputType): array
    {
        return collect(self::variantsForType($inputType))
            ->mapWithKeys(fn ($variant) => [$variant->value => $variant->getLabel()])
            ->toArray();
    }
}
