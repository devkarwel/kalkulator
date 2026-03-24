@component('mail::message')
    # Dziękujemy za konfigurację produktu: {{ $product }}

    W załączniku znajduje się Twoja kalkulacja w formacie PDF.

    Pozdrawiamy,
    {{ config('app.name') }}
@endcomponent
