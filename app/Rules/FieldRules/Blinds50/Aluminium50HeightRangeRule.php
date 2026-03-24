<?php

namespace App\Rules\FieldRules\Blinds50;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class Aluminium50HeightRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 4;
    private const string INPUT_NAME = '35.281'; // Wymiar B
    private const string BLIND_TYPE_SLUG = 'zaluzje_aluminiowe_50_mm';

    private const float MIN_H = 30.0;
    private const float MAX_H = 420.0;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_H, 'max' => self::MAX_H],
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
                return $this->config()['range'];
            }
        }

        return [];
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        return [
            'rodzaj_zaluzji' => $get('rodzaj_zaluzji'),
        ];
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
