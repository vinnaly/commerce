<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Widgets\Widget;

class TotalProdukWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-produk-widget';

    public function getTotal(): int
    {
        return Product::count();
    }
}
