@php
    $chunks = [];
    if (isset($data) && count($data) > 0) {
        $chunks = array_chunk($data, ceil(count($data) / 2));
    }
@endphp

<div class="summary">
    <h3 class="header_label summary__header">Podsumowanie</h3>
    <div class="summary__content">
        <div class="flex flex-col gap-6">
            @if (count($chunks) >= 1)
                @foreach($chunks[0] as $item)
                    @include('filament.user.pages.partials.summary-item', $item)
                @endforeach
            @endif
        </div>
        <div class="flex flex-col gap-6">
            @if (count($chunks) >= 2)
                @foreach($chunks[1] as $item)
                    @include('filament.user.pages.partials.summary-item', $item)
                @endforeach
            @endif

            @if (!empty($price) && isset($price['final_price']))
                <div class="summary__item" style="gap: 0">
                    <h4 class="text-3xl font-bold">Cena</h4>
                    <p class="text-2xl font-semibold" style="color: #9d9067;">
                        <span class="text-base" style="color: initial">
                            @if (isset($price['discount']) && $price['discount'] > 0)
                                całkowita po rabacie:
                            @else
                                całkowita:
                            @endif
                        </span> {{ number_format($price['final_price'], 2, ',', ' ') }} PLN <br/>

                        <span class="text-base" style="color: initial">jednostkowa:</span>
                        {{ number_format(($price['base_price'] ?? 0), 2, ',', ' ') }} PLN <br/>

                        @if (isset($price['discount']) && $price['discount'] > 0)
                            <span class="text-base" style="color: initial">rabat:</span> {{ $price['discount_label'] ?? '' }}<br/>
                        @endif
                    </p>

                    @if (!empty($price_details) && is_array($price_details) && count($price_details) > 0)
                        <div class="mt-4 pt-4 border-t border-gray-300" style="margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid #9d9067;">
                            <h5 class="text-base font-semibold mb-3" style="color: #374151; font-size: 1rem; font-weight: 700; margin-bottom: 0.75rem;">Szczegóły dopłat:</h5>
                            <ul class="text-sm space-y-2" style="list-style: none; padding: 0; margin: 0;">
                                @foreach ($price_details as $detail)
                                    <li class="flex justify-between items-center py-1" style="padding: 0.5rem 0; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                                        <span class="text-gray-700 font-medium" style="font-weight: 600; color: #374151;">{{ $detail['label'] ?? 'Nieznana dopłata' }}</span>
                                        <span class="font-semibold" style="color: {{ isset($detail['action']) && $detail['action'] === 'add' ? '#22c55e' : '#ef4444' }}; font-size: 0.875rem; font-weight: 700; min-width: 30%; text-align: right;">
                                            {{ isset($detail['action']) && $detail['action'] === 'add' ? '+' : '-' }}
                                            {{ number_format($detail['calculated_value'] ?? 0, 2, ',', ' ') }} zł
                                            @if (isset($detail['type']) && $detail['type'] === 'percent')
                                                <br><span class="text-xs text-gray-500 ml-1" style="font-size: 0.75rem; color: #6b7280; margin-left: 0.25rem;">({{ number_format($detail['base_value'] ?? 0, 2, ',', ' ') }}%)</span>
                                            @endif
                                            @if (isset($detail['multiply_by_quantity']) && $detail['multiply_by_quantity'] && isset($detail['quantity']) && $detail['quantity'] > 1)
                                                <br><span class="text-xs text-gray-500 ml-1" style="font-size: 0.75rem; color: #6b7280; margin-left: 0.25rem;">({{ number_format($detail['base_value'] ?? 0, 2, ',', ' ') }} zł × {{ $detail['quantity'] }} szt.)</span>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <div class="summary__actions">
                <x-filament::button
                    type="button"
                    color="secondary"
                    wire:click="preview"
                    class="btn-preview"
                >
                    Pobierz wycene
                </x-filament::button>

                <x-filament::button
                    type="submit"
                    wire:click="submit"
                    color="secondary"
                    class="btn-preview"
                >
                    Wyślij na maila
                </x-filament::button>
            </div>
        </div>
    </div>
    <div>
        <p class="text-center" style="margin-top: 2rem">
            <small>@lang('other.copy')</small>
        </p>
    </div>
</div>


