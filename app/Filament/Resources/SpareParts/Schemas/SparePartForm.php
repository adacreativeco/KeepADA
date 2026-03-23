<?php

namespace App\Filament\Resources\SpareParts\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

use Filament\Forms\Components\Select;

class SparePartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Yedek Parça Bilgileri')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Parça Adı')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('code')
                                    ->label('Stok Kodu')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                Select::make('supplier_id')
                                    ->relationship('supplier', 'name')
                                    ->label('Tedarikçi')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Grid::make(4)
                            ->schema([
                                TextInput::make('unit')
                                    ->label('Birim')
                                    ->default('adet')
                                    ->required(),
                                TextInput::make('stock_quantity')
                                    ->label('Stok Miktarı')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('min_stock')
                                    ->label('Minimum Stok')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('unit_cost')
                                    ->label('Birim Maliyet (₺)')
                                    ->numeric()
                                    ->prefix('₺')
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }
}
