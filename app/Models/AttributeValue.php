<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AttributeValue extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'attribute_id',
        'name',
        'value',
        'label',
        'config',
        'sort_order',
        'collection_id',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function dependencies(): HasMany
    {
        return $this->hasMany(AttributeDependency::class);
    }

    public function unlocks(): HasMany
    {
        return $this->hasMany(AttributeDependency::class, 'depends_on_value_id');
    }

    public function isUnlockedBy(): HasMany
    {
        return $this->hasMany(AttributeDependency::class, 'attribute_value_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attribute')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('attribute')
            ->performOnCollections('attribute')
            ->nonOptimized()
            ->nonQueued();
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class, 'collection_id');
    }

    public function priceRangeConditions()
    {
        return $this->belongsToMany(PriceRangeCondition::class, 'price_range_condition_attribute_value');
    }

    public function priceModifiers(): HasMany
    {
        return $this->hasMany(AttributeValuePriceModifier::class);
    }
}
