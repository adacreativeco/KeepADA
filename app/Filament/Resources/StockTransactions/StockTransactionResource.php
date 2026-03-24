<?php

namespace App\Filament\Resources\StockTransactions;

use App\Filament\Resources\StockTransactions\Pages\ManageStockTransactions;
use App\Models\StockTransaction;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class StockTransactionResource extends Resource
{
    protected static ?string $model = StockTransaction::class;

    protected static ?string $navigationLabel = 'Stok Hareketleri';
    protected static ?string $pluralLabel = 'Stok Hareketleri';
    protected static ?string $modelLabel = 'Stok Hareketi';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sparePart.name')
                    ->label('Parça')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        'adjustment' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Giriş',
                        'out' => 'Çıkış',
                        'adjustment' => 'Düzeltme',
                    }),
                TextColumn::make('quantity')
                    ->label('Miktar')
                    ->numeric(),
                TextColumn::make('user.name')
                    ->label('İşlemi Yapan'),
                TextColumn::make('task.title')
                    ->label('Bağlı Görev')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Hareket Türü')
                    ->options([
                        'in' => 'Giriş',
                        'out' => 'Çıkış',
                        'adjustment' => 'Düzeltme',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                // Stok hareketleri silinmemeli (denetim izi için)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStockTransactions::route('/'),
        ];
    }
}
