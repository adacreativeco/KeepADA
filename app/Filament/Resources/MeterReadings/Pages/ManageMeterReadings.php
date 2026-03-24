<?php

namespace App\Filament\Resources\MeterReadings\Pages;

use App\Filament\Resources\MeterReadings\MeterReadingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMeterReadings extends ManageRecords
{
    protected static string $resource = MeterReadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
