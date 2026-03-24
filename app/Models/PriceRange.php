<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceRange extends Model
{
    protected $fillable = [
        'name',
    ];

    public function steps(): HasMany
    {
        return $this->hasMany(PriceRangeStep::class);
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(PriceRangeCondition::class);
    }

    public function modifiers(): HasMany
    {
        return $this->hasMany(PriceRangeModifier::class);
    }

    public function isFullyMatched(Product $product, array $formData): bool
    {
        foreach ($this->conditions as $condition) {
            // 1. Produkt musi się zgadzać
            if ($condition->product_id !== null && $condition->product_id !== $product->id) {
                return false;
            }

            // 2. Kolekcja: musimy mieć dopasowanie do kolekcji item
            if ($condition->product_collection_id !== null) {
                if ($condition->product_collection_item_id !== null) {
                    $selectedItemId = $formData['collection_1_item_id'] ?? null;
                    if ((int) $selectedItemId !== (int) $condition->product_collection_item_id) {
                        return false;
                    }
                }

                if ($condition->product_collection_item_value_id !== null) {
                    $selectedValueId = $formData['collection_1_value_id'] ?? null;
                    if ((int) $selectedValueId !== (int) $condition->product_collection_item_value_id) {
                        return false;
                    }
                }
            }

            // 3. Atrybut: sprawdzamy, czy wybrano odpowiednią wartość
            if ($condition->attribute_id !== null) {
                // znajdź klucz w formData, który odpowiada temu atrybutowi
                $attribute = Attribute::find($condition->attribute_id);
                if (! $attribute) {
                    return false;
                }

                $key = $attribute->name;

                // Jeśli warunek zawiera konkretne wartości
                if ($condition->attributeValues->isNotEmpty()) {
                    $selectedValueId = $formData[$key] ?? null;

                    if (! $condition->attributeValues->pluck('id')->contains((int) $selectedValueId)) {
                        return false;
                    }
                } else {
                    // Wystarczy, że atrybut został użyty (jakaś wartość jest w formData)
                    $expectedKeys = [
                        $attribute->name,
                        "collection_1_item_id", // fallback do kolekcji
                        "collection_1_value_id",
                    ];

                    $hasAny = collect($expectedKeys)
                        ->filter(fn ($k) => array_key_exists($k, $formData))
                        ->isNotEmpty();

                    if (! $hasAny) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
