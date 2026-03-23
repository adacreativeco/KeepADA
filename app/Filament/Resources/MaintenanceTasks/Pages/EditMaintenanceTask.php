<?php

namespace App\Filament\Resources\MaintenanceTasks\Pages;

use App\Filament\Resources\MaintenanceTasks\MaintenanceTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceTask extends EditRecord
{
    protected static string $resource = MaintenanceTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
