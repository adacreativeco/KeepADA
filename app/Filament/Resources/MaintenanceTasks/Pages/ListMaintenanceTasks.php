<?php

namespace App\Filament\Resources\MaintenanceTasks\Pages;

use App\Filament\Resources\MaintenanceTasks\MaintenanceTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaintenanceTasks extends ListRecords
{
    protected static string $resource = MaintenanceTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
