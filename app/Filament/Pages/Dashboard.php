<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\TopProducts;
use App\Filament\Widgets\TotalProdukWidget;
use App\Filament\Widgets\TotalKategoriWidget;
use App\Filament\Widgets\TotalUserWidget;
use App\Filament\Widgets\MonthlyRevenue;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static bool $shouldRegisterNavigation = false;

    // ✅ Gunakan properti statik, bukan method instance
    protected static array $widgets = [
        TotalProdukWidget::class,
        TotalKategoriWidget::class,
        TotalUserWidget::class,
        MonthlyRevenue::class,
        TopProducts::class,
    ];
}
