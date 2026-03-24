<x-filament-panels::page class="calculator-product">
    {{ $this->form }}

    <div class="summary-box-wrapper">
        <livewire:summary-box :product="$product" wire:key="summary-box" />
    </div>

    <script>
        window.addEventListener('open-pdf-preview', (event) => {
            window.open(event.detail[0].url, '_blank');
        });

        window.addEventListener('scroll-to-top', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
</x-filament-panels::page>
