<?php

namespace App\Rules\FieldRules;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Rules\DynamicRangeValidationRule;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

abstract class AbstractFieldRangeRule implements FieldRulesInterface
{
    abstract protected function config(): array;

    protected function determineRange(Product $product, array $formData): array
    {
        return $this->config()['range'];
    }

    /**
     * Klucze formularza potrzebne do dynamicznego wyznaczenia zakresu.
     * Subklasy nadpisują tę metodę by zwrócić pary key => wartość z Get.
     */
    protected function buildFormDataFromGet(Get $get): array
    {
        return [];
    }

    public function apply(Product $product, array $formData, AttributeValue $value, TextInput $field): void
    {
        $config = $this->config();

        if ("{$value->attribute_id}.{$value->id}" !== $config['input_name']) {
            return;
        }

        // Ustaw statyczne min/max z konfiguracji jako fallback dla HTML5
        $defaultRange = $config['range'] ?? [];
        if (isset($defaultRange['min'])) {
            $field->minValue($defaultRange['min']);
        }
        if (isset($defaultRange['max'])) {
            $field->maxValue($defaultRange['max']);
        }

        // Dodaj reaktywną walidację serwerową opartą na aktualnym stanie formularza
        $field->rules([
            fn (Get $get) => new DynamicRangeValidationRule(
                $this->determineRange($product, $this->buildFormDataFromGet($get))
            ),
        ]);
    }
}
