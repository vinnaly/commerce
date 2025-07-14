<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class MonthlyRevenue extends BaseWidget
{
    protected function getCards(): array
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        // Hitung pendapatan dari order 'paid' pada bulan ini
        $totalRevenue = Order::where('status', 'paid')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('total');

        return [
            Card::make('Pendapatan Bulan Ini', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total dari semua transaksi sukses')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
