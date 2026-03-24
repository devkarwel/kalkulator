<?php

namespace App\Rules\FieldRules\PleatedBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;

class PleatedDimensionTooltipRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 2;
    private const string MONTAZ_INWAZYJNY_SLUG = 'montaz_inwazyjny_w_swietle_szyby';
    private const string MONTAZ_BEZINWAZYJNY_SLUG = 'montaz_bezinwazyjny_na_ramie_okiennej';
    private const string WYMIAR_S_SLUG = 'wymiar_s';
    private const string WYMIAR_W_SLUG = 'wymiar_w';

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID) {
            return;
        }

        if (!in_array($value->name, [self::WYMIAR_S_SLUG, self::WYMIAR_W_SLUG])) {
            return;
        }

        $selectedMontazId = $formData['wybierz_rodzaj_montazu'] ?? null;
        if (!$selectedMontazId) {
            return;
        }

        $montazValue = AttributeValue::find($selectedMontazId);
        if (!$montazValue) {
            return;
        }

        $tooltip = match ([$montazValue->name, $value->name]) {
            [self::MONTAZ_INWAZYJNY_SLUG, self::WYMIAR_S_SLUG]    => 'Szerokość szyby mierzona wraz z uszczelkami',
            [self::MONTAZ_INWAZYJNY_SLUG, self::WYMIAR_W_SLUG]    => 'Wysokość szyby mierzona wraz z uszczelkami',
            [self::MONTAZ_BEZINWAZYJNY_SLUG, self::WYMIAR_S_SLUG] => 'Szerokość szyby mierzona wraz z listwami przyszybowymi',
            [self::MONTAZ_BEZINWAZYJNY_SLUG, self::WYMIAR_W_SLUG] => 'Wysokość szyby mierzona wraz z listwami przyszybowymi',
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
