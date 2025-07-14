<?php

namespace App\Filament\Resources;

use App\Models\Product;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Manajemen Produk';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Produk')
                ->description('Isi data produk dengan lengkap dan jelas')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')
                            ->label('Nama Produk')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        
                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->required(),

                        TextInput::make('price')
                            ->label('Harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp ')
                            ->inputMode('decimal'),

                        TextInput::make('stock')
                            ->label('Stok')
                            ->required()
                            ->numeric(),

                        TextInput::make('weight')
                            ->label('Berat Produk')
                            ->numeric()
                            ->suffix('gram')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required(),

                        Select::make('category_id')
                ->relationship('category', 'name')
                ->required(),
                    ]),

                    Textarea::make('description')
                        ->label('Deskripsi Produk')
                        ->rows(4)
                        ->placeholder('Tulis deskripsi produk secara singkat...'),
                    ]),

                 FileUpload::make('image')
                        ->label('Gambar Produk')
                        ->image()
                        ->directory('products')
                        ->disk('public')
                        ->preserveFilenames()
                    
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('500')
                        ->imageResizeTargetHeight('500')
                        ->imagePreviewHeight('250')
                        ->loadingIndicatorPosition('left')
                        ->panelAspectRatio('2:1')
                        ->panelLayout('integrated')
                        ->removeUploadedFileButtonPosition('right')
                        ->uploadButtonPosition('left')
                        ->uploadProgressIndicatorPosition('left')

                        ->required(fn (string $context) => $context === 'create')
                    ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              ImageColumn::make('image')
                ->label('Gambar')
                ->size(60)
                ->toggleable(),

               TextColumn::make('name')
                ->label('Nama Produk')
                ->limit(30) // Potong teks terlalu panjang
                ->tooltip(fn ($record) => $record->name) // Tampilkan full saat hover
                ->sortable()
                ->searchable()
                ->toggleable()
                ->extraAttributes([
                    'style' => 'max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;',
                ]),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR', true)
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->toggleable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->colors([
                        'draft' => 'gray',
                        'published' => 'success',
                    ])
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return 'Produk';
    }

    public static function getPluralLabel(): string
    {
        return 'Produk';
    }
}
