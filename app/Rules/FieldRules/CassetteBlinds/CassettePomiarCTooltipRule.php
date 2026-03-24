<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;

class CassettePomiarCTooltipRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 1;

    /**
     * Slug of the "Pomiar C" value inside the "wymiary" attribute.
     */
    private const string POMIAR_C_SLUG = 'pomiar_c';

    /**
     * Apply tooltip depending on selected cassette type.
     */
    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        // Apply only for the designated product
        if ($product->id !== self::PRODUCT_ID) {
            return;
        }

        // Ensure we are manipulating the Pomiar C field only
        if ($value->name !== self::POMIAR_C_SLUG) {
            return;
        }

        $selectedCassetteId = $formData['rodzaj_kasety'] ?? null;
        if (!$selectedCassetteId) {
            return;
        }

        $cassetteValue = AttributeValue::find($selectedCassetteId);
        if (!$cassetteValue) {
            return;
        }

        $tooltip = match ($cassetteValue->name) {
            'kaseta_plaska' => 'Wymiar C musi być minimum 2,5 cm mniejszy niż wymiar A',
            'kaseta_przestrzenna' => 'Wymiar C musi wynosić co najmniej 1,5 cm',
            default => null,
        };

        if ($tooltip !== null) {
            $field->hintIcon(icon: asset('images/info.svg'), tooltip: $tooltip);
        }
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
} 