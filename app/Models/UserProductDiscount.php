<?php

namespace App\Models;

use App\Enums\PriceTypeModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProductDiscount extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'discount_value',
        'discount_type',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'discount_type' => PriceTypeModifier::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
