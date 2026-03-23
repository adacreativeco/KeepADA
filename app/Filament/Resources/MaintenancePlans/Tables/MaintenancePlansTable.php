<?php

namespace App\Filament\Resources\MaintenancePlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\Action;
use App\Models\MaintenanceTask;

class MaintenancePlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('equipment.name')
                    ->label('Ekipman')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('frequency_type')
                    ->label('Periyot')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'daily' => 'info',
                        'weekly' => 'success',
                        'monthly' => 'warning',
                        'quarterly' => 'danger',
                        'yearly' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'daily' => 'Günlük',
                        'weekly' => 'Haftalık',
                        'monthly' => 'Aylık',
                        'quarterly' => 'Üç Aylık',
                        'yearly' => 'Yıllık',
                        'custom' => 'Özel',
                    }),
                TextColumn::make('next_due_date')
                    ->label('Sonraki Bakım')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Sorumlu')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->recordActions([
                Action::make('createTask')
                    ->label('Görev Oluştur')
                    ->icon('heroicon-o-plus-circle')
                    ->color('success')
                    ->action(function ($record) {
                        MaintenanceTask::create([
                            'company_id' => $record->company_id,
                            'plan_id' => $record->id,
                            'equipment_id' => $record->equipment_id,
                            'assigned_to' => $record->assigned_to,
                            'title' => $record->title,
                            'type' => 'preventive',
                            'status' => 'pending',
                            'priority' => 'medium',
                            'scheduled_date' => $record->next_due_date,
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}