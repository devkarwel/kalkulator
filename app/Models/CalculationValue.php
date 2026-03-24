<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalculationValue extends Model
{
    protected $fillable = [
        'calculation_id',
        'attribute_id',
        'attribute_value_id',
        'attribute_name',
        'value_label',
    ];

    public function calculation(): BelongsTo
    {
        return $this->belongsTo(Calculation::class);
    }

    // Opcjonalne – tylko jeśli atrybuty i wartości nadal istnieją
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
