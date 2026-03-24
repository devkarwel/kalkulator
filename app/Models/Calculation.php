<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Calculation extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'email',
        'summary',
        'is_read',
        'pdf_path',
    ];

    protected $casts = [
        'summary' => 'array',
        'is_read' => 'boolean',
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
