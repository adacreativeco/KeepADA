<?php

namespace App\Filament\Widgets;

use App\Models\SparePart;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class CriticalStockWidget extends TableWidget
{
    protected static ?string $heading = 'Kritik Stok Uyarısı';
    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return !auth()->user()->hasRole('viewer');
    }

    public function table(Table $table): Table
    {
        $tenant = \Filament\Facades\Filament::getTenant();

        return $table
            ->query(
                SparePart::query()
                    ->where('company_id', $tenant?->id)
                    ->whereColumn('stock_quantity', '<=', 'min_stock')
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Parça Adı'),
                TextColumn::make('code')
                    ->label('Stok Kodu'),
                TextColumn::make('stock_quantity')
                    ->label('Mevcut Stok')
                    ->badge()
                    ->color('danger'),
                TextColumn::make('min_stock')
                    ->label('Min. Stok'),
                TextColumn::make('unit')
                    ->label('Birim'),
            ])
            ->paginated(false);
    }
}
