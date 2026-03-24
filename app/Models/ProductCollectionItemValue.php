<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductCollectionItemValue extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'product_collection_item_id',
        'name',
        'label',
        'value',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('collection_item_value')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('collection_item_value')
            ->width(181)
            ->height(207)
            ->performOnCollections('collection_item_value')
            ->nonOptimized()
            ->nonQueued();
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ProductCollectionItem::class, 'product_collection_item_id');
    }
}
