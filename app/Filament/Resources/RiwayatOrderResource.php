<?php

namespace App\Filament\Resources;

use App\Models\Order;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class RiwayatOrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationLabel = 'Riwayat Transaksi';
    protected static ?string $navigationGroup = 'Manajemen Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('No. Order')->sortable(),
                TextColumn::make('user.name')->label('Customer')->searchable()->placeholder('POS Customer'),
                TextColumn::make('total')->label('Total')->money('IDR'),
                TextColumn::make('source')
                    ->label('Sumber')
                    ->badge()
                    ->colors([
                        'gray' => 'pos',
                        'info' => 'checkout',
                    ]),
                BadgeColumn::make('payment_status')->label('Status Pembayaran')
                    ->colors([
                        'success' => 'paid',
                        'danger' => 'failed',
                        'warning' => 'pending',
                    ]),
                BadgeColumn::make('status')->label('Status Order')
                    ->colors([
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'warning' => 'pending',
                    ]),
                TextColumn::make('updated_at')->label('Tanggal Selesai')->dateTime()->sortable(),
            ])
            ->filters([
                Filter::make('Tanggal')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('updated_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('updated_at', '<=', $data['until']));
                    }),
                SelectFilter::make('source')
                    ->label('Sumber Transaksi')
                    ->options([
                        'pos' => 'POS',
                        'checkout' => 'Checkout',
                    ]),
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->headerActions([
                ExportAction::make('export')->label('Export ke Excel'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereIn('status', ['completed', 'paid']);
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Resources\RiwayatOrderResource\Pages\ListRiwayatOrders::route('/'),
        ];
    }
}
