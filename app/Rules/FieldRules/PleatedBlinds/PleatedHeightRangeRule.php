<?php

namespace App\Rules\FieldRules\PleatedBlinds;

use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class PleatedHeightRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 2;
    private const string INPUT_NAME = '12.32';
    private const float MIN_H = 20;
    private const float MAX_H = 220;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_H, 'max' => self::MAX_H],
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
