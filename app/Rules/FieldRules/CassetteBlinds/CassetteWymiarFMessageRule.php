<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\FieldRules\FieldRulesInterface;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CassetteWymiarFMessageRule implements FieldRulesInterface
{
    private const int PRODUCT_ID = 1;
    private const string WYMIAR_F_SLUG = 'wymiar_f';
    private const float WYMIAR_F_MIN = 1.0;

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        if ($product->id !== self::PRODUCT_ID) {
            return;
        }

        if ($value->name !== self::WYMIAR_F_SLUG) {
            return;
        }

        $field->rules([
            new class(self::WYMIAR_F_MIN) implements ValidationRule {
                public function __construct(private float $min) {}

                public function validate(string $attribute, mixed $val, Closure $fail): void
                {
                    if ((float) $val < $this->min) {
                        $fail('Pole wymiar F musi wynosić co najmniej ' . number_format($this->min, 0, ',', '') . ' cm.');
                    }
                }
            },
        ]);
    }

    public function productIds(): array
    {
        return [self::PRODUCT_ID];
    }
}
