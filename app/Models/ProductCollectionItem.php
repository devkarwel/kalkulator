<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCollectionItem extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['product_collection_id', 'name', 'value', 'label', 'sort_order', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(ProductCollection::class, 'product_collection_id');
    }

    public function values(): HasMany
    {
        return $this->hasMany(ProductCollectionItemValue::class)->orderBy('sort_order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('collection_item');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('collection_item')
            ->width(179)
            ->height(179)
            ->performOnCollections('collection_item')
            ->nonOptimized()
            ->nonQueued();
    }
}
