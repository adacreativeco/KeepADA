<?php

namespace App\Filament\Resources\StockTransactions\Pages;

use App\Filament\Resources\StockTransactions\StockTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStockTransactions extends ManageRecords
{
    protected static string $resource = StockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
