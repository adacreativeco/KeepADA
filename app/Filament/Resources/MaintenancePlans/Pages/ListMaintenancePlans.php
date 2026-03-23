<?php

namespace App\Filament\Resources\MaintenancePlans\Pages;

use App\Filament\Resources\MaintenancePlans\MaintenancePlanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaintenancePlans extends ListRecords
{
    protected static string $resource = MaintenancePlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
