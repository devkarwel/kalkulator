<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PriceRangeCondition extends Model
{
    protected $fillable = [
        'price_range_id',
        'product_id',
        'attribute_id',
        'attribute_value_id',
        'product_collection_id',
        'product_collection_item_id',
        'product_collection_item_value_id',
    ];

    public function priceRange(): BelongsTo
    {
        return $this->belongsTo(PriceRange::class);
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
        return $this->belongsToMany(AttributeValue::class, 'price_range_condition_attribute_value');
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

    public function isMatched(Product $product, array $formData): bool
    {
        if ($this->product->id !== null && $this->product->id !== $product->id) {
            return false;
        }

        if ($this->attribute->id !== null) {
            $attributeName = $this->attribute->name;
            $selectedValueId = $formData[$attributeName] ?? null;

            if ($selectedValueId === null) {
                return false;
            }

            $matchedValues = $this->attributeValues->pluck('id')->map(fn ($id) => (int) $id);

            if ($matchedValues->isNotEmpty() && !$matchedValues->contains((int) $selectedValueId)) {
                return false;
            }
        }

        return true;
    }
}
