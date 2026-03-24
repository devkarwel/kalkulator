<?php

namespace App\Rules\FieldRules\PleatedBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Illuminate\Support\Str;

class PleatedDimensionUValidationRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 2;
    private const string DIMENSION_U_SLUG = 'wymiar_u';


    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID || $value->name !== self::DIMENSION_U_SLUG) {
            return;
        }

        $field->rules([
            function (Get $get) use ($formData) {
                $dimS = $get('12.30');

                return new PleatedDimensionURule($dimS);
            }
        ]);
    }
}
