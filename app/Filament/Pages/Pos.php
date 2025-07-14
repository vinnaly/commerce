<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class Pos extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationLabel = 'Point of Sale';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';
    protected static string $view = 'filament.pages.pos';

    public array $cart = [];

    public $search = '';
    public $selectedCategoryId = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('product_id')
                    ->label('Pilih Produk')
                    ->options(function () {
                        return Product::where('stock', '>', 0)
                            ->get()
                            ->pluck(fn($product) => "{$product->name} (stok: {$product->stock})", 'id');
                    })
                    ->searchable()
                    ->required(),

                TextInput::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('Tambah')
                        ->action(function (array $data) {
                            $product = Product::find($data['product_id']);
                            if (!$product) return;

                            $qty = (int) $data['quantity'];

                            if ($qty > $product->stock) {
                                Notification::make()
                                    ->title("Stok tidak mencukupi (tersisa {$product->stock})")
                                    ->danger()
                                    ->send();
                                return;
                            }

                            $existingIndex = collect($this->cart)->search(fn($item) => $item['product_id'] == $product->id);

                            if ($existingIndex !== false) {
                                $newQty = $this->cart[$existingIndex]['quantity'] + $qty;

                                if ($newQty > $product->stock) {
                                    Notification::make()
                                        ->title("Total Qty melebihi stok (tersisa {$product->stock})")
                                        ->danger()
                                        ->send();
                                    return;
                                }

                                $this->cart[$existingIndex]['quantity'] = $newQty;
                                $this->cart[$existingIndex]['subtotal'] = $product->price * $newQty;
                            } else {
                                $this->cart[] = [
                                    'product_id' => $product->id,
                                    'name' => $product->name,
                                    'price' => $product->price,
                                    'quantity' => $qty,
                                    'subtotal' => $product->price * $qty,
                                ];
                            }
                        })
                        ->color('success')
                        ->label('Tambah ke Transaksi')
                ])
            ]),
        ];
    }

    public function getFilteredProducts()
    {
        $query = Product::where('stock', '>', 0);

        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return $query->get();
    }

    public function filterByCategory($id)
    {
        $this->selectedCategoryId = $id;
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);
        if (!$product || $product->stock < 1) {
            Notification::make()
                ->title('Stok tidak tersedia')
                ->danger()
                ->send();
            return;
        }

        foreach ($this->cart as &$item) {
            if ($item['product_id'] == $productId) {
                $newQty = $item['quantity'] + 1;

                if ($newQty > $product->stock) {
                    Notification::make()
                        ->title("Stok tidak cukup untuk produk ini.")
                        ->danger()
                        ->send();
                    return;
                }

                $item['quantity'] = $newQty;
                $item['subtotal'] = $newQty * $product->price;
                return;
            }
        }

        $this->cart[] = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ];
    }

    public function getTotal()
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function removeItem($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
    }

    public function processOrder()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Keranjang kosong')->danger()->send();
            return;
        }

        // Validasi stok sebelum proses
        foreach ($this->cart as $item) {
            $product = Product::find($item['product_id']);
            if ($item['quantity'] > $product->stock) {
                Notification::make()
                    ->title("Stok produk '{$product->name}' tidak cukup")
                    ->danger()
                    ->send();
                return;
            }
        }

        $order = Order::create([
            'user_id' => auth()->id() ?? null,
            'name' => 'POS Customer',
            'phone' => '-',
            'address' => 'Pembelian langsung di toko',
            'total' => $this->getTotal(),
            'status' => 'paid',
            'payment_method' => 'cash',
            'source' => 'pos',
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            Product::find($item['product_id'])->decrement('stock', $item['quantity']);
        }

        $this->cart = [];
        Notification::make()->title('Transaksi berhasil')->success()->send();
    }

    protected function getViewData(): array
    {
        return [
            'categories' => Category::all(),
            'products' => $this->getFilteredProducts(),
            'cart' => $this->cart,
        ];
    }
}
