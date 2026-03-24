<?php

namespace App\Rules\FieldRules;

use App\Models\AttributeValue;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class FieldRuleManager
{
    /**
     * @var FieldRulesInterface[]
     */
    protected array $rules = [];

    /**
     * @param iterable<FieldRulesInterface> $rules
     */
    public function __construct(iterable $rules)
    {
        foreach ($rules as $rule) {
            $this->rules[] = $rule;
        }
    }

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        foreach ($this->rules as $rule) {
            $rule->apply($product, $formData, $value, $field);
        }
    }
}
