<div class="attribute-select">
    @php
        $options = $getOptions();
        $hasOptions = !empty($options);
    @endphp
    
    @if($hasOptions && $getLabel())
        <h3 class="header_label">{{ $getLabel() }}</h3>
    @endif
    
    <div class="attribute-select__options {{ $getVariant() }}"
         x-data="{
                 state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }},
                 selectValue(value) {
                    this.state = value;
                 }
            }"
    >        
        @if($hasOptions)
            @foreach ($options as $optionValue => $optionLabel)
                @php
                    $valueJson = json_encode($optionValue);
                    $isActive = $optionLabel['is_active'] ?? true;
                @endphp

                <label class="attribute-select__item {{ !$isActive ? 'is-inactive' : '' }}"
                    :class="{ 'is-active': state == {{ $valueJson }} }"
                    @click="@if($isActive) selectValue({{ $valueJson }}) @endif"
                >
                    <input
                        type="radio"
                        name="{{ $getName() }}"
                        value="{{ $optionValue }}"
                        wire:model="{{ $getStatePath() }}"
                        class="hidden"
                        @if(!$isActive) disabled @endif
                    />
                    @switch($getVariant())
                        @case('attribute-select__options--square')
                        @case('attribute-select__options--square-small')
                            @include('filament.forms.components.partials.select-image-square', [
                                'img' => $optionLabel['img'],
                                'label' => $optionLabel['label'],
                                'tooltip' => $optionLabel['tooltip'] ?? false,
                                'hasPriceModifier' => $optionLabel['has_price_modifier'] ?? false,
                                'isActiveExpression' => "state == $valueJson",
                            ])
                            @break
                        @case('attribute-select__options--icon')
                                @include('filament.forms.components.partials.select-image-checkbox', [
                                    'img' => $optionLabel['img'],
                                    'label' => $optionLabel['label'],
                                    'tooltip' => $optionLabel['tooltip'] ?? false,
                                    'hasPriceModifier' => $optionLabel['has_price_modifier'] ?? false,
                                    'isActiveExpression' => "state == $valueJson",
                                ])
                            @break
                        @case('attribute-select__options--circle')
                                @include('filament.forms.components.partials.select-image-circle', [
                                    'img' => $optionLabel['img'],
                                    'label' => $optionLabel['label'],
                                    'tooltip' => $optionLabel['tooltip'] ?? false,
                                    'hasPriceModifier' => $optionLabel['has_price_modifier'] ?? false,
                                    'isActiveExpression' => "state == $valueJson",
                                ])
                            @break
                        @case('attribute-select__options--rectangle')
                            @include('filament.forms.components.partials.select-image-rectangle', [
                                'img' => $optionLabel['img'],
                                'label' => $optionLabel['label'],
                                'tooltip' => $optionLabel['tooltip'] ?? false,
                                'hasPriceModifier' => $optionLabel['has_price_modifier'] ?? false,
                                'isActiveExpression' => "state == $valueJson",
                            ])
                            @break
                        @default
                            @include('filament.forms.components.partials.text-inline', [
                                'label' => $optionLabel['label'],
                                'tooltip' => $optionLabel['tooltip'] ?? false,
                                'hasPriceModifier' => $optionLabel['has_price_modifier'] ?? false,
                                'isActiveExpression' => "state == $valueJson",
                            ])
                    @endswitch
                </label>
            @endforeach
        @endif
    </div>

    @error($getStatePath())
        <p class="error">{{ $message }}</p>
    @enderror
</div>
