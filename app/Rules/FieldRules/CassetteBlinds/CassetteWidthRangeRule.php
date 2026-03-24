<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\AbstractFieldRangeRule;
use Filament\Forms\Get;

class CassetteWidthRangeRule extends AbstractFieldRangeRule
{
    private const int PRODUCT_ID = 1;
    private const string INPUT_NAME = '4.9';
    private const float MIN_WIDTH = 20;
    private const float MAX_WIDTH = 220;

    protected function config(): array
    {
        return [
            'product_id' => self::PRODUCT_ID,
            'input_name' => self::INPUT_NAME,
            'range' => ['min' => self::MIN_WIDTH],
        ];
    }

    protected function determineRange(Product $product, array $formData): array
    {
        $range = $this->config()['range'];
        $range['max'] = 150.0;

        $heightAttr = AttributeValue::find($product->height_attribute);

        if ($heightAttr) {
            $heightValue = $formData[$heightAttr->attribute_id][$heightAttr->id] ?? null;

            if (is_numeric($heightValue)) {
                $height = (float) $heightValue;
                if ($height > 150 && $height <= 220) {
                    $range['max'] = 120.0;
                }
            }
        }

        return $range;
    }

    protected function buildFormDataFromGet(Get $get): array
    {
        // CassetteWidthRangeRule.determineRange() uses height to determine max width.
        // Przekazujemy collection ID potrzebne do logiki.
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
