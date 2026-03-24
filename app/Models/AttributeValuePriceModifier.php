<?php

namespace App\Models;

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttributeValuePriceModifier extends Model
{
    protected $fillable = [
        'attribute_value_id',
        'value',
        'type',
        'action',
        'multiply_by_quantity',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'type' => PriceTypeModifier::class,
        'action' => PriceActionModifier::class,
        'multiply_by_quantity' => 'boolean',
    ];

    public function attributeValue(): BelongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(AttributeValuePriceModifierCondition::class);
    }

    /**
     * Sprawdza czy modyfikator powinien być zastosowany na podstawie wybranych wartości
     */
    public function shouldApply(array $formData, Product $product, ?float $width = null, ?int $quantity = null): bool
    {
        if ($this->conditions->isEmpty()) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            if (!$condition->isMatched($product, $formData, $width, $quantity)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Zastosuj modyfikator do ceny
     */
    public function applyToPrice(float $price, ?int $quantity = null): float
    {
        if ($this->type === PriceTypeModifier::PERCENT) {
            $adjustment = $price * ((float)$this->value / 100);
        } else {
            $adjustment = (float)$this->value;
            
            // Jeśli modyfikator ma być mnożony przez ilość
            if ($this->multiply_by_quantity && $quantity !== null) {
                $adjustment = $adjustment * $quantity;
            }
        }

        return match ($this->action) {
            PriceActionModifier::ADD => $price + $adjustment,
            PriceActionModifier::SUBTRACT => $price - $adjustment,
            default => $price,
        };
    }

    /**
     * Zwraca tekstową reprezentację modyfikatora dla tooltipa
     */
    public function getTooltipText(): string
    {
        $prefix = match ($this->action) {
            PriceActionModifier::ADD => '+',
            PriceActionModifier::SUBTRACT => '-',
            default => '',
        };

        $suffix = match ($this->type) {
            PriceTypeModifier::PERCENT => '%',
            PriceTypeModifier::AMOUNT => ' zł',
            default => '',
        };

        return $prefix . number_format((float)$this->value, 2, ',', ' ') . $suffix;
    }
}

