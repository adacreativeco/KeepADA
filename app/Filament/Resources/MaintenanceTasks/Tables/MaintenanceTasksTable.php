<?php

namespace App\Filament\Resources\MaintenanceTasks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Webbingbrasil\FilamentAdvancedFilter\Filters\BooleanFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\NumberFilter;
use Webbingbrasil\FilamentAdvancedFilter\Filters\TextFilter;

class MaintenanceTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordClasses(fn ($record) => 
                $record->status !== 'done' && $record->scheduled_date->isPast() 
                ? 'bg-rose-50/50' : null
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('equipment.name')
                    ->label('Ekipman')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'preventive' => 'Önleyici',
                        'corrective' => 'Düzeltici',
                        'emergency' => 'Acil',
                    }),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'in_progress' => 'info',
                        'done' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Bekliyor',
                        'in_progress' => 'Devam Ediyor',
                        'done' => 'Tamamlandı',
                        'cancelled' => 'İptal Edildi',
                    }),
                TextColumn::make('priority')
                    ->label('Öncelik')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'warning',
                        'high' => 'danger',
                        'critical' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'low' => 'Düşük',
                        'medium' => 'Orta',
                        'high' => 'Yüksek',
                        'critical' => 'Kritik',
                    }),
                TextColumn::make('scheduled_date')
                    ->label('Planlanan Tarih')
                    ->date('d.m.Y')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->status !== 'done' && $record->scheduled_date->isPast() 
                        ? 'danger' : null
                    )
                    ->weight(fn ($record) => 
                        $record->status !== 'done' && $record->scheduled_date->isPast() 
                        ? 'bold' : null
                    )
                    ->description(fn ($record) => 
                        $record->status !== 'done' && $record->scheduled_date->isPast() 
                        ? 'Gecikti!' : null
                    ),
                TextColumn::make('sla_status')
                    ->label('SLA Durumu')
                    ->badge()
                    ->color(fn ($record) => $record->sla_color),
                TextColumn::make('assignedUser.name')
                    ->label('Teknisyen')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                TextFilter::make('title')->label('Başlık'),
                DateFilter::make('scheduled_date')->label('Planlanan Tarih'),
                NumberFilter::make('actual_cost')->label('Maliyet'),
                SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'pending' => 'Bekliyor',
                        'in_progress' => 'Devam Ediyor',
                        'done' => 'Tamamlandı',
                        'cancelled' => 'İptal Edildi',
                    ]),
                SelectFilter::make('type')
                    ->label('Tür')
                    ->options([
                        'preventive' => 'Önleyici',
                        'corrective' => 'Düzeltici',
                        'emergency' => 'Acil',
                    ]),
                SelectFilter::make('priority')
                    ->label('Öncelik')
                    ->options([
                        'low' => 'Düşük',
                        'medium' => 'Orta',
                        'high' => 'Yüksek',
                        'critical' => 'Kritik',
                    ]),
                SelectFilter::make('sla_status')
                    ->label('SLA Durumu')
                    ->options([
                        'İçinde' => 'SLA İçinde',
                        'Gecikti' => 'SLA Gecikti',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'İçinde') {
                            return $query->whereHas('plan', function ($q) {
                                $q->whereRaw('TIMESTAMPDIFF(HOUR, scheduled_date, completed_at) <= sla_hours');
                            });
                        } elseif ($data['value'] === 'Gecikti') {
                            return $query->whereHas('plan', function ($q) {
                                $q->whereRaw('TIMESTAMPDIFF(HOUR, scheduled_date, completed_at) > sla_hours');
                            });
                        }
                    }),
                SelectFilter::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->label('Teknisyen'),
                SelectFilter::make('location')
                    ->relationship('equipment.location', 'name')
                    ->label('Lokasyon'),
                SelectFilter::make('equipment')
                    ->relationship('equipment', 'name')
                    ->label('Ekipman'),
            ])
            ->actions([
                Action::make('markAsDone')
                    ->label('Tamamlandı İşaretle')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn ($record) => $record->status === 'done' || auth()->user()->hasRole('viewer'))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'done',
                            'completed_at' => now(),
                        ]);
                    }),
                Action::make('assignTechnician')
                    ->label('Teknisyen Ata')
                    ->icon('heroicon-o-user-plus')
                    ->color('info')
                    ->hidden(fn () => auth()->user()->hasRole(['technician', 'viewer']))
                    ->form([
                        \Filament\Forms\Components\Select::make('assigned_to')
                            ->label('Teknisyen')
                            ->relationship('assignedUser', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->action(function ($record, array $data) {
                        $record->update([
                            'assigned_to' => $data['assigned_to'],
                        ]);
                    }),
                EditAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->label('Excel Export'),
                    DeleteBulkAction::make()
                        ->hidden(fn () => auth()->user()->hasRole(['technician', 'viewer'])),
                ]),
            ]);
    }
}