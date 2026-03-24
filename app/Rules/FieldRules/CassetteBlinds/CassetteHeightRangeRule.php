<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class CassetteHeightRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 1;
    private const string INPUT_NAME = '4.10';
    private const float MIN_H = 20;
    private const float MAX_H = 220;
    private const float MAX_H_DN21 = 190;
    private const float MAX_H_DN_PREMIUM = 200;
    private const int COLLECTION_DN_ID = 2;
    private const int COLLECTION_DN_PREMIUM_ID = 4;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_H],
        ];
    }

    protected function determineRange(Product $product, array $formData): array
    {
        $range = $this->config()['range'];

        $range['max']= match ($formData['collection_1_item_id'] ?? null) {
            self::COLLECTION_DN_ID => $formData['collection_1_value_id'] === 10 ? self::MAX_H_DN21 : self::MAX_H,
            self::COLLECTION_DN_PREMIUM_ID => self::MAX_H_DN_PREMIUM,
            default => self::MAX_H,
        };

        return $range;
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        return [
            'collection_1_item_id'  => $get('collection_1_item_id'),
            'collection_1_value_id' => $get('collection_1_value_id'),
        ];
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
