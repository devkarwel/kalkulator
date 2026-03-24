<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class CassetteDimensionCValidationRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 1;

    private const string POMIAR_C_SLUG = 'pomiar_c';

    private const string CASETTE_PLASKA_SLUG = 'kaseta_plaska';
    private const string CASETTE_PRZESTRZENNA_SLUG = 'kaseta_przestrzenna';

    private const float PRZESTRZENNA_ABSOLUTE_MIN = 1.5;
    private const float PLASKA_MIN_DIFF_FROM_A = 2.5;

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID) {
            return;
        }

        if ($value->name !== self::POMIAR_C_SLUG) {
            return;
        }

        $field->rules([
            function (Get $get) {
                $cassetteId = $get('rodzaj_kasety');
                $selectedCassette = $cassetteId ? AttributeValue::find($cassetteId) : null;
                $cassetteType = $selectedCassette?->name ?? '';

                $dimensionAValue = $get('4.9');

                return new CassetteDimensionCRule(
                    $dimensionAValue,
                    self::PLASKA_MIN_DIFF_FROM_A,
                    $cassetteType,
                    self::PRZESTRZENNA_ABSOLUTE_MIN
                );
            }
        ]);

        // Absolutne minimum dla kasety przestrzennej jako HTML5 attribute
        $field->minValue(self::PRZESTRZENNA_ABSOLUTE_MIN);
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
