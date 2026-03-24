<?php

namespace App\Rules\FieldRules\Blinds25;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;

class AluminiumAndWood25MountingTooltipRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 3;
    private const string WIDTH_SLUG = 'wymiar_a'; // corresponds to 23.123
    private const string HEIGHT_SLUG = 'wymiar_b'; // corresponds to 23.124

    // Slugs dla wartości atrybutu "Sposób mocowania"
    private const string MOUNT_VER_1 = 'mocowanie_rynny_gornej_w_swietle_szyby';
    private const string MOUNT_VER_2 = 'mocowanie_rynny_gornej_na_rame_okienna';
    private const string MOUNT_VER_3 = 'mocowanie_bezinwazyjne_rynny_gornej';

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID) {
            return;
        }

        if ($value->name !== self::WIDTH_SLUG && $value->name !== self::HEIGHT_SLUG) {
            return;
        }

        $mountingId = $formData['rodzaj_mocowania'] ?? null;
        if (!$mountingId) {
            return;
        }

        $mountingVal = AttributeValue::find($mountingId);
        if (!$mountingVal) {
            return;
        }

        $tooltip = null;
        if ($mountingVal->name === self::MOUNT_VER_1) {
            $tooltip = match ($value->name) {
                self::WIDTH_SLUG => 'Szerokość mierzona od uszczelki do uszczelki',
                self::HEIGHT_SLUG => 'Wysokość mierzona od uszczelki do uszczelki',
                default => null
            };
        }

        if ($mountingVal->name === self::MOUNT_VER_2) {
            $tooltip = match ($value->name) {
                self::WIDTH_SLUG => 'Szerokość mierzona od początku listwy przyszybowej do końca drugiej listwy przyszybowej',
                self::HEIGHT_SLUG => 'Wysokość mierzona od góry ramy okiennej do końca dolnej listwy przyszybowej',
                default => null
            };
        }

        if ($mountingVal->name === self::MOUNT_VER_3) {
            $tooltip = match ($value->name) {
                self::WIDTH_SLUG => 'Szerokość mierzona od początku listwy przyszybowej do końca drugiej listwy przyszybowej',
                self::HEIGHT_SLUG => 'Wysokość mierzona od góry ramy okiennej do końca dolnej listwy przyszybowej',
                default => null
            };
        }

        if ($tooltip !== null) {
            $field->hintIcon(icon: asset('images/info.svg'), tooltip: $tooltip);
        }
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
