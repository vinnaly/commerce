<?php

namespace App\Filament\Resources;
use Filament\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
   protected static ?string $navigationLabel = 'Pesanan Masuk';
protected static ?string $navigationGroup = 'Manajemen Transaksi';
protected static ?string $model = \App\Models\Order::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->where('status', '!=', 'completed'); // hanya menampilkan order yang belum selesai
}

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('id')->label('No Order')->sortable(),
            TextColumn::make('user.name')->label('Customer')->searchable(),
            TextColumn::make('total')->money('IDR')->label('Total'),
            BadgeColumn::make('payment_status')
                ->colors([
                    'secondary' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ]),
            BadgeColumn::make('status')
                ->colors([
                    'secondary' => 'pending',
                    'success' => 'completed',
                    'warning' => 'processing',
                ]),
            TextColumn::make('created_at')->label('Tanggal')->dateTime()->sortable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'shipped' => 'Shipped',
                ])
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\ViewAction::make(),
        ])
        ->defaultSort('created_at', 'desc');
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
