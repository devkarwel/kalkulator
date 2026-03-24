<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .logo img { height: 80px; }
        .company-info { text-align: right; font-size: 12px; }
        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { border: 1px solid #999; padding: 6px; text-align: left; }
        .noborder { border: 0 none; }
        .footer { margin-top: 40px; font-size: 12px; text-align: right; color: #666;}
        .summary-td-label { width: 200px }
        .list-no-style { list-style: none; padding-left: 0; margin: 0 }
        .copy-legal { text-align: center; }
    </style>
</head>
<body>
<table class="noborder">
    <tbody>
    <tr>
        <td class="noborder">
            @if ($company && $company->hasMedia('logo'))
            <div class="logo">
                <img src="{{ $company->getFirstMediaPath('logo') }}" alt="Logo" />
            </div>
            @endif
        </td>
        <td class="noborder">
            <div class="company-info">
                <strong>{{ $company->name }}</strong><br>
                {{ $company->address }}<br>
                NIP: {{ $company->tax_id }}<br>
                Tel: {{ $company->phone }}{{ $company->phone_alt ? ', ' . $company->phone_alt : '' }}<br>
                Email: {{ $company->email }}<br>
                Nr konta: {{ $company->bank_account }}
            </div>
        </td>
    </tr>
    </tbody>
</table>
<div class="section-title">Dane kontrahenta</div>
<table>
    <tbody>
    <tr>
        <th class="summary-td-label">ID klienta</th>
        <td>{{ $summary['user']->name ?? '' }}</td>
    </tr>
    <tr>
        <th class="summary-td-label">Firma</th>
        <td>{{ $summary['user']->company ?? '' }}</td>
    </tr>
    <tr>
        <th class="summary-td-label">Adres</th>
        <td>{{ $summary['user']->address ?? '' }}</td>
    </tr>
    </tbody>
</table>
<div class="section-title">Dane zamówienia</div>
<table>
    <thead>
        <tr>
            <th class="summary-td-label">Nazwa</th>
            <th>Wartość</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Produkt</td>
            <td>{{ $product }}</td>
        </tr>
        @foreach ($summary['data'] as $item)
            @if ($item['type'] === 'field_input')
                <tr>
                    <td>{{ $item['label'] }}</td>
                    <td>
                        <ul class="list-no-style">
                            @foreach ($item['value'] as $val)
                                @if (empty($val['value']))
                                    @continue
                                @endif

                                <li>{{ $val['label'] }}:
                                    @if ($val['value'])
                                        {{ $val['value'] }} {{ $val['unit'] }}
                                    @else
                                        -
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @else
                <tr>
                    <td>{{ $item['label'] }}</td>
                    <td>
                        {{ $item['value'] }}
                        @if (isset($item['price_modifiers']) && count($item['price_modifiers']) > 0)
                            <br>
                            @foreach($item['price_modifiers'] as $modifier)
                                <span style="color: #dc2626; font-weight: 600;">dopłata {!! $modifier['text'] !!}</span>
                                @if (!$loop->last)<br>@endif
                            @endforeach
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
<div class="section-title">Wstępna wycena</div>
<table>
    <tbody>
    @php
        $basePrice = $priceInfo['base_price'] ?? 0;
        $quantity = $priceInfo['quantity'] ?? 1;
        $unitPrice = $basePrice; // Cena jednostkowa = cena bazowa (bez dopłat)
    @endphp
    <tr>
        <td class="summary-td-label">Cena jednostkowa</td>
        <td>{{ number_format($unitPrice, 2, ',', ' ') }} zł</td>
    </tr>
    @if (!empty($summary['price_details']) && is_array($summary['price_details']) && count($summary['price_details']) > 0)
        <tr>
            <td class="summary-td-label" colspan="2"><strong>Dopłaty:</strong></td>
        </tr>
        @foreach ($summary['price_details'] as $detail)
            <tr>
                <td class="summary-td-label" style="padding-left: 20px;">{{ $detail['label'] ?? 'Dopłata' }}</td>
                <td>
                    <span style="color: {{ isset($detail['action']) && $detail['action'] === 'add' ? '#22c55e' : '#ef4444' }}; font-weight: 600;">
                        {{ number_format($detail['base_value'] ?? 0, 2, ',', ' ') }} zł
                        @if (isset($detail['multiply_by_quantity']) && $detail['multiply_by_quantity'])
                            / szt
                        @endif
                        @if (isset($detail['type']) && $detail['type'] === 'percent')
                            <span style="font-size: 10px;">({{ number_format($detail['base_value'] ?? 0, 2, ',', ' ') }}%)</span>
                        @endif
                    </span>
                </td>
            </tr>
            @if (isset($detail['multiply_by_quantity']) && $detail['multiply_by_quantity'] && isset($detail['quantity']) && $detail['quantity'] > 1)
                <tr>
                    <td class="summary-td-label" style="padding-left: 40px;">ilość:</td>
                    <td>{{ $detail['quantity'] }}</td>
                </tr>
            @endif
        @endforeach
        @php
            $totalModifiers = 0;
            foreach ($summary['price_details'] as $detail) {
                $value = $detail['calculated_value'] ?? 0;
                if (isset($detail['action']) && $detail['action'] === 'add') {
                    $totalModifiers += $value;
                } else {
                    $totalModifiers -= $value;
                }
            }
        @endphp
        @if ($totalModifiers != 0)
            @php
                // Znajdź pierwszą dopłatę z multiply_by_quantity dla wyświetlenia szczegółów
                $firstMultiplierDetail = null;
                foreach ($summary['price_details'] as $detail) {
                    if (isset($detail['multiply_by_quantity']) && $detail['multiply_by_quantity'] && isset($detail['quantity']) && $detail['quantity'] > 1) {
                        $firstMultiplierDetail = $detail;
                        break;
                    }
                }
            @endphp
            <tr>
                <td class="summary-td-label"><strong>Suma dopłat</strong></td>
                <td><strong style="color: {{ $totalModifiers > 0 ? '#22c55e' : '#ef4444' }};">{{ number_format($totalModifiers, 2, ',', ' ') }} zł</strong>
                    @if ($firstMultiplierDetail)
                        <span style="font-size: 10px;">({{ $firstMultiplierDetail['quantity'] }} × {{ number_format($firstMultiplierDetail['base_value'] ?? 0, 2, ',', ' ') }} zł)</span>
                    @endif
                </td>
            </tr>
        @endif
    @endif
    <tr>
        <td class="summary-td-label">Rabat</td>
        <td>{{ $priceInfo['discount_label'] ?? '' }}</td>
    </tr>
    <tr>
        <td class="summary-td-label"><strong>Cena końcowa</strong></td>
        <td><strong>{{ number_format($priceInfo['final_price'] ?? 0, 2, ',', ' ') }} zł</strong></td>
    </tr>
    </tbody>
</table>
<div class="footer" style="margin-top: 1rem">
    Kalkulacja z dnia: {{ now()->format('d.m.Y H:i') }}
    <br>
    <p class="copy-legal"><small>@lang('other.copy')</small></p>
</div>
</body>
</html>
