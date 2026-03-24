<x-filament::page class="calculator-products">
    <div class="calculator-products__header">
        <img src="{{ asset('logo.png') }}" alt="Karwel" class="header-logo" />
        <h3 class="header-normal">Ciepłe promienie słońca czy przytulny półmrok?</h3>
        <h3 class="header-bold">Teraz to Ty decydujesz!</h3>
    </div>

    <div class="product-box-list product-box-list--{{ count($this->products) }}">
        @foreach ($this->products as $product)
            <a href="{{ route('filament.user.pages.kalkulator.{slug}', ['slug' => $product->slug]) }}" class="product-box">
                <picture class="product-box__image">
                    <img src="{{ $product->getFirstMediaUrl('cover') }}"
                         alt=""
                         class="scale-100 transition-transform w-full h-full object-cover"
                    />
                </picture>
                <h3 class="product-box__name">{{ $product->name }}</h3>
            </a>
        @endforeach
    </div>
</x-filament::page>
