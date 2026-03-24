<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeValuePriceModifierCondition extends Model
{
    protected $fillable = [
        'attribute_value_price_modifier_id',
        'product_id',
        'attribute_id',
        'operator',
        'product_collection_id',
        'product_collection_item_id',
        'product_collection_item_value_id',
        'min_width',
        'max_width',
        'min_quantity',
        'max_quantity',
    ];

    protected $casts = [
        'min_width' => 'decimal:2',
        'max_width' => 'decimal:2',
        'min_quantity' => 'integer',
        'max_quantity' => 'integer',
    ];

    public function modifier(): BelongsTo
    {
        return $this->belongsTo(AttributeValuePriceModifier::class, 'attribute_value_price_modifier_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValues(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_value_price_modifier_condition_attribute_value');
    }

    public function productCollection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class);
    }

    public function productCollectionItem(): BelongsTo
    {
        return $this->belongsTo(ProductCollectionItem::class);
    }

    public function productCollectionItemValue(): BelongsTo
    {
        return $this->belongsTo(ProductCollectionItemValue::class);
    }

    /**
     * Sprawdza czy warunek jest spełniony na podstawie danych formularza
     */
    public function isMatched(Product $product, array $formData, ?float $width = null, ?int $quantity = null): bool
    {
        // 1. Sprawdź produkt
        if ($this->product_id !== null && $this->product_id !== $product->id) {
            return false;
        }

        // 2. Sprawdź szerokość
        if ($width !== null) {
            if ($this->min_width !== null && $width < (float)$this->min_width) {
                return false;
            }
            if ($this->max_width !== null && $width > (float)$this->max_width) {
                return false;
            }
        }

        // 3. Sprawdź ilość
        if ($quantity !== null) {
            if ($this->min_quantity !== null && $quantity < $this->min_quantity) {
                return false;
            }
            if ($this->max_quantity !== null && $quantity > $this->max_quantity) {
                return false;
            }
        }

        // 4. Sprawdź kolekcję
        if ($this->product_collection_id !== null) {
            // Jeśli ustawiono tylko product_collection_id bez item_id i value_id,
            // to warunek pasuje do każdej wartości kolekcji (niezależnie od koloru)
            if ($this->product_collection_item_id === null && $this->product_collection_item_value_id === null) {
                // Sprawdź czy jakakolwiek kolekcja została wybrana
                $hasCollectionSelected = false;
                foreach ($formData as $key => $value) {
                    if (str_starts_with($key, 'collection_') && str_ends_with($key, '_item_id')) {
                        $hasCollectionSelected = true;
                        break;
                    }
                }
                if (!$hasCollectionSelected) {
                    return false;
                }
            } else {
                // Sprawdź konkretny item i value - szukaj po ID kolekcji
                $collectionId = $this->product_collection_id;

                if ($this->product_collection_item_id !== null) {
                    $selectedItemId = $formData["collection_{$collectionId}_item_id"] ?? null;
                    if ((int) $selectedItemId !== (int) $this->product_collection_item_id) {
                        return false;
                    }
                }

                if ($this->product_collection_item_value_id !== null) {
                    $selectedValueId = $formData["collection_{$collectionId}_value_id"] ?? null;
                    if ((int) $selectedValueId !== (int) $this->product_collection_item_value_id) {
                        return false;
                    }
                }
            }
        }

        // 5. Sprawdź atrybut i jego wartości z uwzględnieniem operatora
        if ($this->attribute_id !== null) {
            $attribute = Attribute::find($this->attribute_id);
            if (!$attribute) {
                return false;
            }

            $key = $attribute->name;
            $selectedValueId = $formData[$key] ?? null;
            $operator = $this->operator ?? '=';

            // Operator "*" - dowolna wartość atrybutu (wystarczy że atrybut jest wybrany)
            if ($operator === '*') {
                if (!array_key_exists($key, $formData) || empty($selectedValueId)) {
                    return false;
                }
                return true;
            }

            // Jeśli warunek zawiera konkretne wartości atrybutu
            if ($this->attributeValues->isNotEmpty()) {
                $valueIds = $this->attributeValues->pluck('id');
                $isInList = $valueIds->contains((int) $selectedValueId);

                switch ($operator) {
                    case '=':
                        if (!$isInList) {
                            return false;
                        }
                        break;
                    case '!=':
                        if ($isInList) {
                            return false;
                        }
                        break;
                }
            } else {
                // Brak konkretnych wartości - wystarczy że atrybut jest wybrany
                if (!array_key_exists($key, $formData) || empty($selectedValueId)) {
                    return false;
                }
            }
        }

        return true;
    }
}

