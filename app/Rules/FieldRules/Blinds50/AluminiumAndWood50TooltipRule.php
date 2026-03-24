<?php

namespace App\Rules\FieldRules\Blinds50;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;

class AluminiumAndWood50TooltipRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 4;

    private const string WIDTH_SLUG = 'wymiar_a'; // corresponds 35.279
    private const string HEIGHT_SLUG = 'wymiar_b'; // corresponds to 35.280
    private const int MOUNT_WALL = 244;
    private const int MOUNT_SURFACE = 245;


    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID) {
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

        if ($mountingVal->id === self::MOUNT_WALL) {
            $tooltip = match ($value->name) {
                self::WIDTH_SLUG => 'szerokość mierzona wnęki okiennej + 10cm',
                self::HEIGHT_SLUG => 'wysokość mierzona wnęki okiennej + wysokość pakietu złożonej żaluzji',
                default => null,
            };
        }

        if ($mountingVal->id === self::MOUNT_SURFACE) {
            $tooltip = match ($value->name) {
                self::WIDTH_SLUG => 'szerokość mierzona wnęki okiennej + 10cm',
                self::HEIGHT_SLUG => 'wysokość mierzona od sufitu do parapetu – 1cm',
                default => null,
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
