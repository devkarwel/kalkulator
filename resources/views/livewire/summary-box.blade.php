<div class="summary-box">
    <button
        type="button"
        wire:click="toggleVisibility"
        class="summary-box__toggle"
    >
        <svg width="33" height="33" viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 3.38462V29.6154C1 30.9324 2.06763 32 3.38462 32H29.6154C30.9324 32 32 30.9324 32 29.6154V3.38462C32 2.06763 30.9324 1 29.6154 1H3.38462C2.06763 1 1 2.06763 1 3.38462Z" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.5385 26.0383V14.1152" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.5384 14.1153C12.5139 14.1153 14.1153 12.5138 14.1153 10.5383C14.1153 8.56286 12.5139 6.96143 10.5384 6.96143C8.56292 6.96143 6.96149 8.56286 6.96149 10.5383C6.96149 12.5138 8.56292 14.1153 10.5384 14.1153Z" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.4615 6.96143V14.1153" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.4615 21.269V26.0383" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M22.4615 21.2691C24.4369 21.2691 26.0384 19.6676 26.0384 17.6922C26.0384 15.7167 24.4369 14.1152 22.4615 14.1152C20.486 14.1152 18.8846 15.7167 18.8846 17.6922C18.8846 19.6676 20.486 21.2691 22.4615 21.2691Z" stroke="#9D9067" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    @if($visible)
        <div class="summary-box__content">
            <h3 class="summary-box__header">Podsumowanie</h3>
            @php
                $summaryData = collect($summaryData)->filter(function ($item) {
                    if (is_array($item['value'])) {
                        return count(array_filter($item['value'])) > 0;
                    }

                    return !empty($item['value']);
                });
            @endphp
            <ul class="summary-box__list">
                @forelse($summaryData as $item)
                    <li
                        class="summary-box__list-item"
                        wire:key="{{ md5($item['label'] . (is_array($item['value']) ? implode(';', $item['value']) : $item['value'])) }}"
                    >
                        <span class="summary-box__label">{{ $item['label'] }}</span>
                        <span class="summary-box__value">
                            @if(is_array($item['value']))
                                <ul class="summary-box__value-list">
                                    @foreach ($item['value'] as $line)
                                        @if(!empty($line))
                                            <li>{{ $line }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            @else
                                {{ $item['value'] }}
                            @endif
                        </span>
                        @if (isset($item['price_modifiers']) && is_array($item['price_modifiers']) && count($item['price_modifiers']) > 0)
                            <div class="summary-box__price-modifiers" style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid #e5e7eb;">
                                @foreach($item['price_modifiers'] as $modifier)
                                    <p style="font-weight: 600; font-size: 0.75rem; margin-top: 0.25rem; line-height: 1.4;">
                                        <span style="color: {{ isset($modifier['action']) && $modifier['action'] === 'add' ? '#22c55e' : '#ef4444' }};">
                                            dopłata {{ $modifier['text'] }}
                                        </span>
                                    </p>
                                @endforeach
                            </div>
                        @endif
                    </li>
                @empty
                    <li class="text-gray-400 italic">Rozpocznij konfigurację</li>
                @endforelse
            </ul>

            @if (!empty($priceInfo) && isset($priceInfo['final_price']))
                <div class="summary-box__price" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid #9d9067;">
                    <h4 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 0.75rem; color: #9d9067;">Cena</h4>
                    <div style="font-size: 1.125rem; font-weight: 600; color: #9d9067; margin-bottom: 0.5rem;">
                        <span style="font-size: 0.875rem; color: #374151; font-weight: normal;">
                            @if (isset($priceInfo['discount']) && $priceInfo['discount'] > 0)
                                całkowita po rabacie:
                            @else
                                całkowita:
                            @endif
                        </span>
                        {{ number_format($priceInfo['final_price'], 2, ',', ' ') }} PLN
                    </div>
                    <div style="font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">
                        <span style="font-weight: 600;">jednostkowa:</span>
                        {{ number_format($priceInfo['final_price'] / max(1, $priceInfo['quantity'] ?? 1), 2, ',', ' ') }} PLN
                    </div>
                    @if (isset($priceInfo['discount']) && $priceInfo['discount'] > 0)
                        <div style="font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">
                            <span style="font-weight: 600;">rabat:</span> {{ $priceInfo['discount_label'] ?? '' }}
                        </div>
                    @endif

                    @if (!empty($priceDetails) && is_array($priceDetails) && count($priceDetails) > 0)
                        <div style="margin-top: 1rem; padding-top: 0.75rem; border-top: 1px solid #e5e7eb;">
                            <h5 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem; color: #374151;">Szczegóły dopłat:</h5>
                            <ul style="font-size: 0.75rem; list-style: none; padding: 0; margin: 0; space-y: 0.25rem;">
                                @foreach ($priceDetails as $detail)
                                    <li style="display: flex; justify-content: space-between; align-items: center; padding: 0.25rem 0;">
                                        <span style="color: #374151; font-weight: 500;">{{ $detail['label'] }}</span>
                                        <span style="font-weight: 600; color: {{ $detail['action'] === 'add' ? '#22c55e' : '#ef4444' }}">
                                            {{ $detail['action'] === 'add' ? '+' : '-' }}
                                            {{ number_format($detail['calculated_value'], 2, ',', ' ') }} zł
                                            @if ($detail['type'] === 'percent')
                                                <span style="font-size: 0.7rem; color: #6b7280; margin-left: 0.25rem;">({{ number_format($detail['base_value'], 2, ',', ' ') }}%)</span>
                                            @endif
                                            @if ($detail['multiply_by_quantity'] && $detail['quantity'] > 1)
                                                <span style="font-size: 0.7rem; color: #6b7280; margin-left: 0.25rem;">({{ number_format($detail['base_value'], 2, ',', ' ') }} zł × {{ $detail['quantity'] }} szt.)</span>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>
