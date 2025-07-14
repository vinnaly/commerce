<?php

namespace App\Filament\Resources\RiwayatOrderResource\Pages;

use App\Filament\Resources\RiwayatOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatOrders extends ListRecords
{
    protected static string $resource = RiwayatOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
