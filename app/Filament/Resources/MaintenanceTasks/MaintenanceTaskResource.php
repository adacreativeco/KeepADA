<?php

namespace App\Filament\Resources\MaintenanceTasks;

use App\Filament\Resources\MaintenanceTasks\Pages\CreateMaintenanceTask;
use App\Filament\Resources\MaintenanceTasks\Pages\EditMaintenanceTask;
use App\Filament\Resources\MaintenanceTasks\Pages\ListMaintenanceTasks;
use App\Filament\Resources\MaintenanceTasks\Pages\ViewMaintenanceTask;
use App\Filament\Resources\MaintenanceTasks\Schemas\MaintenanceTaskForm;
use App\Filament\Resources\MaintenanceTasks\Schemas\MaintenanceTaskInfolist;
use App\Filament\Resources\MaintenanceTasks\Tables\MaintenanceTasksTable;
use App\Models\MaintenanceTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use App\Filament\Resources\MaintenanceTasks\RelationManagers\SparePartsRelationManager;

class MaintenanceTaskResource extends Resource
{
    protected static ?string $model = MaintenanceTask::class;

    protected static ?string $navigationLabel = 'Bakım Görevleri';
    protected static ?string $pluralLabel = 'Bakım Görevleri';
    protected static ?string $modelLabel = 'Bakım Görevi';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Schema $schema): Schema
    {
        return MaintenanceTaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MaintenanceTaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaintenanceTasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SparePartsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMaintenanceTasks::route('/'),
            'create' => CreateMaintenanceTask::route('/create'),
            'view' => ViewMaintenanceTask::route('/{record}'),
            'edit' => EditMaintenanceTask::route('/{record}/edit'),
        ];
    }
}
