<?php

namespace App\Filament\Resources\Suppliers\RelationManagers;

use App\Filament\Resources\Equipment\EquipmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Schemas\Schema;

use App\Filament\Resources\Equipment\Schemas\EquipmentForm;
use App\Filament\Resources\Equipment\Tables\EquipmentTable;

class EquipmentRelationManager extends RelationManager
{
    protected static string $relationship = 'equipment';

    public function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return EquipmentTable::configure($table)
            ->recordTitleAttribute('name')
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
