<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PriceRangeStep extends Model
{
    protected $fillable = [
        'price_range_id',
        'min_width',
        'max_width',
        'min_height',
        'max_height',
        'price',
    ];

    protected $casts = [
        'price' => 'float',
        'min_width' => 'float',
        'max_width' => 'float',
        'min_height' => 'float',
        'max_height' => 'float',
    ];

    public function priceRange(): BelongsTo
    {
        return $this->belongsTo(PriceRange::class);
    }
}
