<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use App\Models\MaintenanceTask;
use Filament\Tables\Columns\TextColumn;

class UpcomingTasksTable extends TableWidget
{
    protected static ?string $heading = 'Bu Hafta Yapılacak Bakımlar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MaintenanceTask::query()
                    ->whereBetween('scheduled_date', [now()->startOfWeek(), now()->endOfWeek()])
                    ->where('status', '!=', 'done')
            )
            ->columns([
                TextColumn::make('scheduled_date')
                    ->label('Tarih')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                TextColumn::make('equipment.name')
                    ->label('Ekipman'),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Bekliyor',
                        'in_progress' => 'Devam Ediyor',
                        'done' => 'Tamamlandı',
                        'cancelled' => 'İptal Edildi',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
