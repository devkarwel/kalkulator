<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CompanyInfo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'phone_alt',
        'email',
        'bank_account',
        'tax_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('logo')
            ->width(310)
            ->height(83)
            ->performOnCollections('logo')
            ->nonOptimized()
            ->nonQueued();
    }
}
