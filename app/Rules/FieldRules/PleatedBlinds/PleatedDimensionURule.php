<?php

namespace App\Rules\FieldRules\PleatedBlinds;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PleatedDimensionURule implements ValidationRule
{
    protected float $dimS;

    public function __construct(?string $dimS)
    {
        $this->dimS = (float) $dimS;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ((float) $value >= $this->dimS) {
            $fail('Wymiar U musi być mniejszy od wymiaru S.');
        }
    }
}
