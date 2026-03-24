<?php

namespace App\Rules\FieldRules\CassetteBlinds;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CassetteDimensionCRule implements ValidationRule
{
    protected float $dimA;
    protected float $minDiff;
    protected string $cassetteType;
    protected float $absoluteMin;

    public function __construct(
        ?string $dimA,
        float $minDiff = 2.5,
        string $cassetteType = '',
        float $absoluteMin = 0.0
    ) {
        $this->dimA = (float) $dimA;
        $this->minDiff = $minDiff;
        $this->cassetteType = $cassetteType;
        $this->absoluteMin = $absoluteMin;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $c = (float) $value;

        // Dla kasety przestrzennej: absolutne minimum C >= 1.5 cm
        if ($this->cassetteType === 'kaseta_przestrzenna' && $this->absoluteMin > 0) {
            if ($c < $this->absoluteMin) {
                $formattedMin = number_format($this->absoluteMin, 1, ',', '');
                $fail("Wymiar C musi wynosić co najmniej {$formattedMin} cm.");
                return;
            }
        }

        // Dla kasety płaskiej: C musi być wystarczająco mniejszy od A
        if ($this->cassetteType === 'kaseta_plaska' && $this->dimA > 0) {
            $diff = $this->dimA - $c;
            if ($diff < $this->minDiff) {
                $formattedMinDiff = number_format($this->minDiff, 1, ',', '');
                $fail("Wymiar C musi być minimum {$formattedMinDiff} cm mniejszy niż wymiar A.");
            }
        }
    }
}
