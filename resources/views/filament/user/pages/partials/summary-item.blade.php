@if($item['type'] === 'product')
    <div class="summary__item">
        <h4 class="summary__title summary__title--product">
            <small>{{ $item['label'] }}</small>
            {{ $item['value'] }}
        </h4>
    </div>
@elseif ($item['type'] === 'field_input')
    <div class="summary__item">
        @if (strtolower($item['label']) === 'ilość')
            <h5 class="summary__title">
                <small>{{ $item['label'] }}</small>
                @foreach($item['value'] as $val)
                    {{ $val['value'] }}
                @endforeach
            </h5>
        @else
            <h5 class="summary__title">
                <small>{{ $item['label'] }}</small>
            </h5>
            <div class="summary__list">
                @foreach($item['value'] as $val)
                    @if (isset($val['value']) && $val['value'] !== '')
                        <p>{{ $val['label'] }} - {{ $val['value'] ? $val['value'] . ' ' . $val['unit'] : '' }}</p>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="summary__item">
        <h5 class="summary__title">
            <small>{{ $item['label'] }}</small>
            {{ $item['value'] }}
        </h5>
        @if (array_key_exists('image', $item) && $item['image'] !== "")
            <img src="{{ $item['image'] }}" alt="{{ $item['label'] }}" class="summary__image" />
        @endif
        @if (isset($item['price_modifiers']) && is_array($item['price_modifiers']) && count($item['price_modifiers']) > 0)
            <div class="summary__price-modifiers" style="margin-top: 0.75rem; padding-top: 0.5rem; border-top: 1px solid #e5e7eb;">
                @foreach($item['price_modifiers'] as $modifier)
                    <p style="font-weight: 600; font-size: 0.875rem; margin-top: 0.25rem; line-height: 1.5;">
                        <span style="color: {{ isset($modifier['action']) && $modifier['action'] === 'add' ? '#22c55e' : '#ef4444' }};">
                            dopłata {{ $modifier['text'] }}
                        </span>
                    </p>
                @endforeach
            </div>
        @endif
    </div>
@endif
