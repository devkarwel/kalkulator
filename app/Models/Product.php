<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property string $name
 */
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'width_attribute',
        'height_attribute',
        'depth_attribute',
        'quantity_attribute',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function collections(): HasMany
    {
        return $this->hasMany(ProductCollection::class);
    }

    public function attributeDependencies(): HasMany
    {
        return $this->hasMany(AttributeDependency::class);
    }

    public function userDiscounts(): HasMany
    {
        return $this->hasMany(UserProductDiscount::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('cover')
            ->width(482)
            ->height(528)
            ->performOnCollections('cover')
            ->nonOptimized()
            ->nonQueued();
    }
}
