<div class="attribute-select__value attribute-select__value--rectangle box"
     :class="{ 'box--active': {{ $isActiveExpression }} }">
    @if ($img)
        <picture class="box__image box__image--rectangle relative">
            <img src="{{ $img }}" alt="{{ $label }}" />
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
    <div class="box__label box__label--light place-content-around">
        <span>{{ $label }}</span>
    </div>
</div>
