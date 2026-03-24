<?php

namespace App\Services;

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\PriceRange;
use App\Models\PriceRangeModifier;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PriceCalculator
{
    private ?User $user = null;

    public function __construct(
        protected Product $product,
    ) {
        $this->user = Auth::user();

        if ($this->user === null) {
            abort(404, 'Brak zalogowanego użytkownika!');
        }
    }

    public function calculate(array $formData): array
    {
        $selectedValues = $this->extractAttributeValues($formData);

        $matchedRange = $this->getPriceRange($selectedValues);

        if (! $matchedRange) {
            throw new \Exception('Nie znaleziono odpowiedniego cennika dla wybranej konfiguracji. Upewnij się, że wszystkie wymagane atrybuty są wypełnione i aktywne.');
        }

        $inputUser = $this->getDimensionsAndQuantityValue($formData);

        // Zaokrąglamy wymiary w górę (ceil) do pełnego cm, by wartości jak 60,1
        // trafiały do wyższego przedziału cennika (60,1 → 61 → przedział 61-120).
        // Wartości całkowite pozostają bez zmian (ceil(60) = 60).
        $width = (float) ceil($inputUser['width']);
        $height = (float) ceil($inputUser['height']);

        $step = $matchedRange->steps->first(
            fn ($step) =>
                $width >= (float) $step->min_width && $width <= (float) $step->max_width &&
                $height >= (float) $step->min_height && $height <= (float) $step->max_height
        );

        if (! $step) {
            throw new \Exception('Nie znaleziono przedziału cennika dla podanych wymiarów. Sprawdź czy wymiary mieszczą się w zakresie cennika.');
        }

        $basePrice = $step->price;
        $finalPrice = $basePrice * $inputUser['quantity'];

        foreach ($matchedRange->modifiers as $modifier) {
            if (str_starts_with($modifier->attribute?->name, 'collection_')) {
                continue;
            }

            $attributeName = $modifier->attribute?->name ?? null;

            if (!$attributeName || !array_key_exists($attributeName, $formData)) {
                continue;
            }

            if ((int) $formData[$attributeName] === (int) $modifier->attribute_value_id) {
                $finalPrice = $this->applyModifier($finalPrice, $modifier);
            }
        }

        // Zastosuj dopłaty z wartości atrybutów
        $modifiersResult = $this->applyAttributeValueModifiers($finalPrice, $formData);
        $finalPrice = $modifiersResult['price'];
        $appliedModifiers = $modifiersResult['applied_modifiers'];

        $final = $this->applyUserDiscount($finalPrice);

        return [
            'base_price' => $basePrice,
            'price' => round($finalPrice, 2),
            'quantity' => $inputUser['quantity'],
            'discount' => round($finalPrice - $final['final'], 2),
            'discount_label' => $final['label'],
            'final_price' => round($final['final'], 2),
            'applied_modifiers' => $appliedModifiers,
        ];
    }

    private function getDimensionsAndQuantityValue(array $formData): array
    {
        $data = [
            'width' => 0,
            'height' => 0,
            'depth' => 0,
            'quantity' => 1,
        ];

        foreach ($formData as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            foreach ($value as $k => $v) {
                switch ($k) {
                    case $this->product->width_attribute:
                        $data['width'] = (float)$v;
                        break;
                    case $this->product->height_attribute:
                        $data['height'] = (float)$v;
                        break;
                    case $this->product->quantity_attribute:
                        $data['quantity'] = (int)$v === 0 ? 1 : (int)$v;
                        break;
                }
            }
        }

        return $data;
    }

    private function extractAttributeValues(array $formData): array
    {
        $data = [];

        if (count($formData) === 0) {
            return $data;
        }

        foreach ($formData as $key => $value) {
            if (str_starts_with($key, 'collection_') && str_ends_with($key, '_item_id')) {
                $nrCollection = Str::between($key, 'collection_', '_item_id');

                $data['collection'] = [
                    'item_id' => $value,
                    'value_id' => $formData["collection_{$nrCollection}_value_id"],
                ];

                continue;
            }

            if (is_numeric($key) && is_array($value)) {
                $attr = Attribute::query()->where('id', (int) $key)->first();

                if (!$attr) {
                    continue;
                }

                $data['fields'][$attr->name] = $value;

                continue;
            }

            $attribute = Attribute::query()->where('name', $key)->first();

            if (!$attribute) {
                continue;
            }

            if ($value !== null) {
                $data['attributes'][$attribute->name] = $value;
            }
        }

        return $data;
    }

    private function getPriceRange(array $selectedDataValues): ?PriceRange
    {
        if (count($selectedDataValues) === 0) {
            return null;
        }

        $query = PriceRange::query()
            ->with(['steps', 'modifiers'])
            ->whereHas('conditions', function ($query) use ($selectedDataValues) {
                $query->where('product_id', $this->product->id);

                if (isset($selectedDataValues['collection'])) {
                    $query->where('product_collection_item_id', $selectedDataValues['collection']['item_id']);
                }
            });

        $attributeValues = $selectedDataValues['attributes'] ?? [];

        if (!empty($attributeValues)) {
            $query->whereHas('conditions.attributeValues', function ($q) use ($attributeValues) {
                $q->whereIn('attribute_value_id', array_values($attributeValues));
            });
        }

        return $query->first();
    }

    protected function applyModifier(float $price, PriceRangeModifier $modifier): float
    {
        if ($modifier->type === PriceTypeModifier::PERCENT) {
            $adjustment = $price * ((float)$modifier->value / 100);
        } else {
            $adjustment = (float)$modifier->value;
        }

        return match ($modifier->action) {
            PriceActionModifier::ADD => $price + $adjustment,
            PriceActionModifier::SUBTRACT => $price - $adjustment,
            default => $price,
        };
    }
    /**
     * Zastosuj dopłaty z wartości atrybutów
     */
    protected function applyAttributeValueModifiers(float $price, array $formData): array
    {
        $selectedAttributeValueIds = $this->getSelectedAttributeValueIds($formData);
        $appliedModifiers = [];

        if (empty($selectedAttributeValueIds)) {
            return [
                'price' => $price,
                'applied_modifiers' => $appliedModifiers,
            ];
        }

        $inputUser = $this->getDimensionsAndQuantityValue($formData);
        $width = $inputUser['width'];
        $quantity = $inputUser['quantity'];

        $modifiers = AttributeValuePriceModifier::query()
            ->whereIn('attribute_value_id', $selectedAttributeValueIds)
            ->with(['conditions.attributeValues', 'attributeValue'])
            ->get();

        foreach ($modifiers as $modifier) {
            if ($modifier->shouldApply($formData, $this->product, $width, $quantity)) {
                $oldPrice = $price;
                $price = $modifier->applyToPrice($price, $quantity);

                if ($modifier->type === PriceTypeModifier::PERCENT) {
                    $adjustment = $oldPrice * ((float)$modifier->value / 100);
                } else {
                    $adjustment = $modifier->multiply_by_quantity && $quantity > 0
                        ? (float)$modifier->value * $quantity
                        : (float)$modifier->value;
                }

                if ($modifier->action === PriceActionModifier::SUBTRACT) {
                    $adjustment = -$adjustment;
                }

                $appliedModifiers[] = [
                    'label' => $modifier->attributeValue->label ?? 'Nieznana wartość',
                    'base_value' => (float)$modifier->value,
                    'calculated_value' => abs($adjustment),
                    'action' => $modifier->action->value,
                    'type' => $modifier->type->value,
                    'multiply_by_quantity' => $modifier->multiply_by_quantity,
                    'quantity' => $quantity,
                    'modifier_id' => $modifier->id,
                    'attribute_value_id' => $modifier->attribute_value_id,
                ];
            }
        }

        return [
            'price' => $price,
            'applied_modifiers' => $appliedModifiers,
        ];
    }

    /**
     * Pobierz ID wybranych wartości atrybutów z formularza
     */
    protected function getSelectedAttributeValueIds(array $formData): array
    {
        $ids = [];

        foreach ($formData as $key => $value) {
            // Pomijamy kolekcje i pola input (które są tablicami)
            if (str_starts_with($key, 'collection_') || is_array($value)) {
                continue;
            }

            // Jeśli klucz jest liczbą całkowitą, to jest to ID atrybutu
            if (is_int($key)) {
                continue;
            }

            // Sprawdź czy to wartość atrybutu
            $attribute = Attribute::query()->where('name', $key)->first();
            if ($attribute && $value !== null) {
                $ids[] = (int) $value;
            }
        }

        return $ids;
    }

    protected function applyUserDiscount(float $price): array
    {
        $discount = 0;
        $label = null;

        if ($this->user) {
            $productDiscount = $this->user->discountForProduct($this->product);

            $value = $productDiscount?->discount_value ?? null;
            $type = $productDiscount?->discount_type ?? null;

            if ($type && $value) {
                if ($type === PriceTypeModifier::PERCENT) {
                    $discount = ($price * (float)$value) / 100;
                    $label = '-' . $value . '%';
                } elseif ($type === PriceTypeModifier::AMOUNT) {
                    $discount = (float)$value;
                    $label = '-' . number_format($discount, 2, ',', ' ') . ' zł';
                }
            }
        }

        return [
            'final' => max(0, $price - $discount),
            'label' => $label,
        ];
    }
}
