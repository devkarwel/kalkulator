<?php

namespace App\Rules;

use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinQuantityForWidthRule implements ValidationRule
{
    public function __construct(
        protected Product $product,
        protected array $formData,
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $quantity = (int) $value;
        $width = $this->getWidthFromFormData();

        if ($width === null || $quantity <= 0) {
            return;
        }

        // Pobierz wszystkie wybrane wartości atrybutów
        $selectedAttributeValueIds = $this->getSelectedAttributeValueIds();

        if (empty($selectedAttributeValueIds)) {
            return;
        }

        // Sprawdź warunki dla każdego modyfikatora
        $modifiers = AttributeValuePriceModifier::query()
            ->whereIn('attribute_value_id', $selectedAttributeValueIds)
            ->with(['conditions', 'attributeValue'])
            ->get();

        foreach ($modifiers as $modifier) {
            foreach ($modifier->conditions as $condition) {
                // Sprawdź czy szerokość mieści się w warunku
                $widthMatches = true;
                
                if ($condition->min_width !== null && $width < (float)$condition->min_width) {
                    $widthMatches = false;
                }
                if ($condition->max_width !== null && $width > (float)$condition->max_width) {
                    $widthMatches = false;
                }

                // Jeśli szerokość pasuje do warunku i jest wymagana minimalna ilość
                if ($widthMatches && $condition->min_quantity !== null) {
                    if ($quantity < $condition->min_quantity) {
                        $attributeLabel = $modifier->attributeValue->label ?? 'wybrana opcja';
                        
                        $widthRange = '';
                        if ($condition->min_width !== null && $condition->max_width !== null) {
                            $widthRange = " (szerokość {$condition->min_width}-{$condition->max_width} cm)";
                        } elseif ($condition->min_width !== null) {
                            $widthRange = " (szerokość ≥{$condition->min_width} cm)";
                        } elseif ($condition->max_width !== null) {
                            $widthRange = " (szerokość ≤{$condition->max_width} cm)";
                        }

                        $fail("Dla opcji \"{$attributeLabel}\"{$widthRange} wymagana jest minimalna ilość {$condition->min_quantity} szt.");
                        return;
                    }
                }
            }
        }
    }

    protected function getWidthFromFormData(): ?float
    {
        if (!$this->product->width_attribute) {
            return null;
        }

        foreach ($this->formData as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            foreach ($value as $k => $v) {
                if ($k == $this->product->width_attribute) {
                    return (float)$v;
                }
            }
        }

        return null;
    }

    protected function getSelectedAttributeValueIds(): array
    {
        $ids = [];

        foreach ($this->formData as $key => $value) {
            // Pomiń wartości które nie są ID atrybutów
            if (is_array($value)) {
                continue;
            }

            // Sprawdź czy to jest wartość atrybutu (numeryczne ID)
            if (is_numeric($value)) {
                $ids[] = (int)$value;
            }
        }

        return $ids;
    }
}


