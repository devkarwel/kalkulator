<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DynamicRangeValidationRule implements ValidationRule
{
    public function __construct(private readonly array $range) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($this->range)) {
            return;
        }

        $v = (float) $value;

        if (isset($this->range['min']) && $v < (float) $this->range['min']) {
            $fail("Wartość musi wynosić co najmniej {$this->range['min']} cm.");
        }

        if (isset($this->range['max']) && $v > (float) $this->range['max']) {
            $fail("Wartość nie może przekraczać {$this->range['max']} cm.");
        }
    }
}
