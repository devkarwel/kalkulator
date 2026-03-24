<?php

namespace App\Models;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Attribute extends Model
{
    protected $fillable = [
        'product_id',
        'required',
        'input_type',
        'input_variant',
        'name',
        'label',
        'column_side',
        'nr_step',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'required' => 'boolean',
        'input_type' => AttributeInputType::class,
        'input_variant' => AttributeInputVariant::class,
        'column_side' => AttributeSideColumn::class,
        'is_active' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function values(): HasMany
    {
        return $this
            ->hasMany(AttributeValue::class)
            ->orderBy('sort_order');
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(AttributeDependency::class);
    }

    public function priceModifiers(): HasManyThrough
    {
        return $this->hasManyThrough(
            AttributeValuePriceModifier::class,
            AttributeValue::class,
            'attribute_id', // Foreign key on AttributeValue table
            'attribute_value_id', // Foreign key on AttributeValuePriceModifier table
            'id', // Local key on Attribute table
            'id' // Local key on AttributeValue table
        );
    }
}
