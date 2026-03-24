<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeDependency extends Model
{
    protected $fillable = [
        'attribute_id',
        'attribute_value_id',
        'depends_on_attribute_id',
        'depends_on_value_id',
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function value(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id');
    }

    public function dependsOnAttribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class, 'depends_on_attribute_id');
    }

    public function dependsOnValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class, 'depends_on_value_id');
    }
}
