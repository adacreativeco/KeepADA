<?php

namespace App\Filament\Resources\MaintenanceTasks\Pages;

use App\Filament\Resources\MaintenanceTasks\MaintenanceTaskResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaintenanceTask extends ViewRecord
{
    protected static string $resource = MaintenanceTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
