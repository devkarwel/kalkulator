<?php

namespace App\Rules\FieldRules\Blinds25;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class Wood25WidthRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 3;
    private const string INPUT_NAME = '23.124'; // szerokość
    private const string BLIND_TYPE_SLUG = 'zaluzje_drewniane_25_mm';

    private const float MIN_W = 40.0;
    private const float MAX_W_DEFAULT = 270.0;
    private const float MAX_W_BAMBUS = 180.0;

    protected function config(): array
    {
        // zwracamy tylko produkt i input_name, zakres będzie wyliczany dynamicznie
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_W],
        ];
    }

    protected function determineRange(Product $product, array $formData): array
    {
        if (
            !empty($formData) &&
            isset($formData['rodzaj_zaluzji'])
        ) {
            $blindType = AttributeValue::find($formData['rodzaj_zaluzji']);
            if ($blindType && $blindType->name === self::BLIND_TYPE_SLUG) {
                $max = self::MAX_W_DEFAULT;

                // sprawdzamy czy wybrano bambusową lamelę
                if (isset($formData['kolor_lameli'])) {
                    $color = AttributeValue::find($formData['kolor_lameli']);
                    if ($color && $color->name === 'bambusowa') {
                        $max = self::MAX_W_BAMBUS;
                    }
                }

                return ['min' => self::MIN_W, 'max' => $max];
            }
        }

        return [];
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        return [
            'rodzaj_zaluzji' => $get('rodzaj_zaluzji'),
            'kolor_lameli'   => $get('kolor_lameli'),
        ];
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
