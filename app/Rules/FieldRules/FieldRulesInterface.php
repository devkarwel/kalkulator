<?php

namespace App\Rules\FieldRules;

use App\Models\AttributeValue;
use App\Models\Product;
use Filament\Forms\Components\TextInput;

interface FieldRulesInterface
{
    /**
     * @return int[]
     */
    public function productIds(): array;

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void;
}
