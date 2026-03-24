<div class="attribute-select__value attribute-select__value--inline">
    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="24" cy="24" r="24" fill="white"/>
        <path
            x-show="{{ $isActiveExpression }}"
            d="M19.6364 34L12 23.5238L19.6364 28.2857L40 14L19.6364 34Z" fill="#9D9067"/>
    </svg>

    <span>{{ $label }}</span>

    @if ($tooltip)
        @if (isset($hasPriceModifier) && $hasPriceModifier)
            <x-filament::icon-button
                icon="heroicon-o-currency-dollar"
                color="primary"
                class="attribute__tooltip"
                tooltip="{{ $tooltip }}" />
        @else
            <x-filament::icon-button
                icon="heroicon-o-question-mark-circle"
                color="primary"
                class="attribute__tooltip"
                tooltip="{{ $tooltip }}" />
        @endif
    @endif
</div>
