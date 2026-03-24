<?php

namespace App\Filament\Resources\SpareParts;

use App\Filament\Resources\SpareParts\Pages\CreateSparePart;
use App\Filament\Resources\SpareParts\Pages\EditSparePart;
use App\Filament\Resources\SpareParts\Pages\ListSpareParts;
use App\Filament\Resources\SpareParts\Schemas\SparePartForm;
use App\Filament\Resources\SpareParts\Tables\SparePartsTable;
use App\Models\SparePart;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Resources\SpareParts\RelationManagers\StockTransactionsRelationManager;

class SparePartResource extends Resource
{
    protected static ?string $model = SparePart::class;

    protected static ?string $navigationLabel = 'Yedek Parçalar';
    protected static ?string $pluralLabel = 'Yedek Parçalar';
    protected static ?string $modelLabel = 'Yedek Parça';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cube';

    public static function getNavigationBadge(): ?string
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        
        if (!$tenant) return null;

        $count = static::getModel()::query()
            ->where('company_id', $tenant->id)
            ->whereColumn('stock_quantity', '<=', 'min_stock')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return SparePartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SparePartsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            StockTransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSpareParts::route('/'),
            'create' => CreateSparePart::route('/create'),
            'edit' => EditSparePart::route('/{record}/edit'),
        ];
    }
}
