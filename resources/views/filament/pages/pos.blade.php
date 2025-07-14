<x-filament::page>
    <div class="grid grid-cols-12 gap-4">
        <!-- Kategori -->
        <div class="col-span-12 flex flex-wrap gap-2">
            @foreach ($categories as $category)
                <button 
                    wire:click="filterByCategory({{ $category->id }})"
                    class="px-4 py-2 bg-gray-100 hover:bg-primary-600 hover:text-white rounded shadow-sm transition">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Pencarian -->
        <div class="col-span-12 mt-2">
            <input 
                type="text" 
                wire:model="search" 
                placeholder="Cari produk..." 
                class="w-full border rounded p-2 shadow-sm"
            >
        </div>

        <!-- Daftar Produk -->
        <div class="col-span-8 grid grid-cols-3 gap-4 mt-2">
            @forelse ($products as $product)
    <div 
        class="border rounded-lg p-4 text-center hover:shadow-lg cursor-pointer"
        wire:click="addToCart({{ $product->id }})"
    >
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 mx-auto object-contain mb-2">
        
        <h4 class="text-sm font-semibold">{{ $product->name }}</h4>
        
        <p class="text-primary-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        
        <p class="text-xs text-gray-500 mt-1">
            Stok: 
            @if($product->stock > 0)
                <span class="text-green-600 font-medium">{{ $product->stock }}</span>
            @else
                <span class="text-red-600 font-medium">Habis</span>
            @endif
        </p>
    </div>
@empty
    <p class="col-span-3 text-gray-500">Produk tidak ditemukan.</p>
@endforelse

        </div>

        <!-- Detail & Transaksi -->
        <div class="col-span-4">
            <div class="border p-4 rounded-lg shadow space-y-4">
                <h3 class="text-lg font-bold">DETAIL TRANSAKSI</h3>

                @if (count($cart) > 0)
                    <table class="w-full text-sm">
                        <thead>
                            <tr>
                                <th class="text-left">Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $index => $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                    <td>
                                        <button wire:click="removeItem({{ $index }})" class="text-red-500 text-xs">✖</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 border-t pt-2 flex justify-between font-bold">
                        <span>Total:</span>
                        <span>Rp {{ number_format($this->getTotal(), 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-4 text-right">
                        <x-filament::button wire:click="processOrder">
                            Bayar Sekarang
                        </x-filament::button>
                    </div>
                @else
                    <p class="text-gray-600">Belum ada produk yang dipilih.</p>
                @endif
            </div>
        </div>
    </div>
</x-filament::page>
