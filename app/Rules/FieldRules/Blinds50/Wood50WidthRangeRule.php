<?php

namespace App\Rules\FieldRules\Blinds50;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class Wood50WidthRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 4; // Żaluzje 50mm
    private const string INPUT_NAME = '35.280'; // Wymiar A
    private const string BLIND_TYPE_SLUG = 'zaluzje_drewniane_50_mm';

    private const float MIN_W = 60.0;
    private const float MAX_W_DEFAULT = 270.0;
    private const float MAX_W_BAMBUS = 240.0;
    private const float MAX_W_PURE_SPECIAL = 360.0;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_W, 'max' => self::MAX_W_DEFAULT],
        ];
    }

    protected function determineRange(Product $product, array $formData): array
    {
        if (
            !empty($formData) &&
            isset($formData['rodzaj_zaluzji'])
        ) {
            $blindType = AttributeValue::find($formData['rodzaj_zaluzji']);
            if (!$blindType || $blindType->name !== self::BLIND_TYPE_SLUG) {
                return [];
            }
            
            $max = self::MAX_W_DEFAULT;

            // Sprawdź kolor lameli
            if (isset($formData['kolor_lameli'])) {
                $colorLameli = AttributeValue::find($formData['kolor_lameli']);
                if ($colorLameli) {
                    if ($colorLameli->name === 'bambusowa') {
                        $max = self::MAX_W_BAMBUS;
                    } elseif ($colorLameli->name === 'drewnianapure') {
                        // sprawdź konkretny numer koloru
                        if (isset($formData['kolory_do_wyboru'])) {
                            $chosenColor = AttributeValue::find($formData['kolory_do_wyboru']);
                            if ($chosenColor && in_array($chosenColor->name, ['5020', '5021'], true)) {
                                $max = self::MAX_W_PURE_SPECIAL;
                            }
                        }
                    }
                }
            }

            return ['min' => self::MIN_W, 'max' => $max];
        }

        return [];
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        return [
            'rodzaj_zaluzji'  => $get('rodzaj_zaluzji'),
            'kolor_lameli'    => $get('kolor_lameli'),
            'kolory_do_wyboru' => $get('kolory_do_wyboru'),
        ];
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
