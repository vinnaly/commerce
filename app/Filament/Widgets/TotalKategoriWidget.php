<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\Widget;

class TotalKategoriWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-kategori-widget';

    public function getTotal(): int
    {
        return Category::count();
    }
}
