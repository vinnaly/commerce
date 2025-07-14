<x-filament::widget>
    <x-filament::card>
        <div class="text-center">
            <h2 class="text-lg font-semibold">Total Produk</h2>
            <p class="text-3xl font-bold text-primary mt-2">
                {{ $this->getTotal() }}
            </p>
        </div>
    </x-filament::card>
</x-filament::widget>
