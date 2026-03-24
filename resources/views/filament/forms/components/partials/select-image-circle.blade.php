<div class="attribute-select__value attribute-select__value--circle box p-3"
     :class="{ 'box--active': {{ $isActiveExpression }} }">
    @if ($img)
        <picture class="box__image box__image--circle">
            <img src="{{ $img }}" alt="{{ $label }}" class="rounded-full" />
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
        </picture>
    @endif
    <div class="box__label box__label--light">
        <span>{{ $label }}</span>
    </div>
</div>
