<?php

namespace App\Rules\FieldRules\Blinds25;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class Aluminium25WidthRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 3;
    private const string INPUT_NAME = '23.124';
    private const string BLIND_TYPE_SLUG = 'zaluzje_aluminiowe_25_mm';
    private const float MIN_W = 40.0;
    private const float MAX_W = 290.0;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => [
                'min' => self::MIN_W,
                'max' => self::MAX_W,
            ],
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
