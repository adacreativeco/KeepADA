<?php

namespace App\Filament\Resources\MaintenanceTasks\Pages;

use App\Filament\Resources\MaintenanceTasks\MaintenanceTaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceTask extends CreateRecord
{
    protected static string $resource = MaintenanceTaskResource::class;
}
