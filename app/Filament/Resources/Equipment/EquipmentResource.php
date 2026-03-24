<?php

namespace App\Filament\Resources\Equipment;

use App\Filament\Resources\Equipment\Pages\CreateEquipment;
use App\Filament\Resources\Equipment\Pages\EditEquipment;
use App\Filament\Resources\Equipment\Pages\ListEquipment;
use App\Filament\Resources\Equipment\Pages\ViewEquipment;
use App\Filament\Resources\Equipment\Schemas\EquipmentForm;
use App\Filament\Resources\Equipment\Schemas\EquipmentInfolist;
use App\Filament\Resources\Equipment\Tables\EquipmentTable;
use App\Models\Equipment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Resources\Equipment\RelationManagers\MaintenancePlansRelationManager;
use App\Filament\Resources\Equipment\RelationManagers\MaintenanceTasksRelationManager;
use App\Filament\Resources\Equipment\RelationManagers\MaintenanceHistoryRelationManager;
use App\Filament\Resources\Equipment\RelationManagers\MeterReadingsRelationManager;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationLabel = 'Ekipmanlar';
    protected static ?string $pluralLabel = 'Ekipmanlar';
    protected static ?string $modelLabel = 'Ekipman';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog';

    public static function canCreate(): bool
    {
        $tenant = \Filament\Facades\Filament::getTenant();
        
        if (!$tenant) return true;

        return $tenant->equipment()->count() < $tenant->max_equipment;
    }

    public static function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EquipmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            MaintenancePlansRelationManager::class,
            MaintenanceTasksRelationManager::class,
            MaintenanceHistoryRelationManager::class,
            MeterReadingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipment::route('/'),
            'create' => CreateEquipment::route('/create'),
            'view' => ViewEquipment::route('/{record}'),
            'edit' => EditEquipment::route('/{record}/edit'),
        ];
    }
}
