<?php

namespace App\Models;

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class PriceRangeModifier extends Model
{
    public $fillable = [
        'price_range_id',
        'attribute_id',
        'attribute_value_id',
        'value',
        'type',
        'action',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'type' => PriceTypeModifier::class,
        'action' => PriceActionModifier::class,
    ];

    public function priceRange(): BelongsTo
    {
        return $this->belongsTo(PriceRange::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(): BelongsToMany
    {
        return $this->belongsToMany(AttributeValue::class, 'attr_vpr_modifier');
    }

    public function appliesTo(Collection $selectedValues): bool
    {
        // 1. Konkretna wartość wybrana
        if ($this->attribute_value_id !== null) {
            return $selectedValues->contains('id', $this->attribute_value_id);
        }

        // 2. Jakakolwiek wartość z danego atrybutu
        if ($this->attribute_id !== null) {
            return $selectedValues->contains(fn ($val) => $val->attribute_id === $this->attribute_id);
        }

        return false;
    }
}
