@php
    $modifiers = $modifiers ?? collect();
@endphp

@if($modifiers->isEmpty())
    <div class="text-sm text-gray-500 p-4 bg-gray-50 rounded-lg">
        Brak istniejących dopłat dla wartości tego atrybutu.
    </div>
@else
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3">Nazwa atrybutu</th>
                    <th scope="col" class="px-4 py-3">Operacja</th>
                    <th scope="col" class="px-4 py-3">Wartość</th>
                    <th scope="col" class="px-4 py-3">Ilość warunków</th>
                </tr>
            </thead>
            <tbody>
                @foreach($modifiers as $modifier)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                            {{ $modifier->attributeValue->label ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($modifier->action->value === 'add')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Dolicz
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Odlicz
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $prefix = $modifier->action->value === 'add' ? '+' : '-';
                                $suffix = $modifier->type->value === 'percent' ? '%' : ' zł';
                            @endphp
                            {{ $prefix }}{{ number_format((float)$modifier->value, 2, ',', ' ') }}{{ $suffix }}
                            @if($modifier->multiply_by_quantity)
                                <span class="text-xs text-gray-500">(za sztukę)</span>
                            @else
                                <span class="text-xs text-gray-500">(jednorazowa)</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $conditionsCount = $modifier->conditions->count();
                            @endphp
                            @if($conditionsCount > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $conditionsCount }} warunków
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Zawsze
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

