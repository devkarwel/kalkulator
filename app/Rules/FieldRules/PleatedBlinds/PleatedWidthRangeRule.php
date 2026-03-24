<?php

namespace App\Rules\FieldRules\PleatedBlinds;

use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class PleatedWidthRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 2;
    private const string INPUT_NAME = '12.30';
    private const float MIN_W = 20;
    private const float MAX_W = 120;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_W, 'max' => self::MAX_W],
        ];
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        return [];
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
