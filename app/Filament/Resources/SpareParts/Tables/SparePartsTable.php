<?php

namespace App\Filament\Resources\SpareParts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;

class SparePartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Parça Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->label('Stok Kodu')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('stock_quantity')
                    ->label('Mevcut Stok')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->stock_quantity <= $record->min_stock ? 'danger' : 'success')
                    ->description(fn ($record) => $record->stock_quantity <= $record->min_stock ? 'Kritik Seviye!' : null),
                TextColumn::make('unit')
                    ->label('Birim'),
                TextColumn::make('unit_cost')
                    ->label('Birim Maliyet')
                    ->money('try')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
