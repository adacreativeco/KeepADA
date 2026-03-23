<?php

namespace App\Filament\Resources\Equipment\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Carbon\Carbon;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kod')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Ekipman Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location.name')
                    ->label('Lokasyon')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'passive' => 'warning',
                        'scrapped' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'passive' => 'Pasif',
                        'scrapped' => 'Hurda',
                    }),
                TextColumn::make('warranty_end_date')
                    ->label('Garanti Bitiş')
                    ->date('d.m.Y')
                    ->sortable()
                    ->color(fn ($record) => 
                        $record->warranty_end_date && $record->warranty_end_date->isBefore(now()->addDays(30)) 
                        ? 'warning' : null
                    )
                    ->icon(fn ($record) => 
                        $record->warranty_end_date && $record->warranty_end_date->isBefore(now()->addDays(30)) 
                        ? 'heroicon-m-exclamation-circle' : null
                    )
                    ->description(fn ($record) => 
                        $record->warranty_end_date && $record->warranty_end_date->isBefore(now()->addDays(30)) 
                        ? 'Yakında bitiyor!' : null
                    ),
                TextColumn::make('predictive_next_due_date')
                    ->label('Tahmini Bakım')
                    ->date('d.m.Y')
                    ->description('Zekâ Tahmini')
                    ->color('info'),
                TextColumn::make('maintenanceTasks')
                    ->label('Son Bakım')
                    ->state(fn ($record) => $record->maintenanceTasks()->where('status', 'done')->latest('completed_at')->first()?->completed_at)
                    ->date('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('location_id')
                    ->relationship('location', 'name')
                    ->label('Lokasyon'),
                SelectFilter::make('category')
                    ->options([
                        'Elektrik' => 'Elektrik',
                        'Mekanik' => 'Mekanik',
                        'HVAC' => 'HVAC',
                        'Asansör' => 'Asansör',
                        'Jeneratör' => 'Jeneratör',
                        'Diğer' => 'Diğer',
                    ])
                    ->label('Kategori'),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'passive' => 'Pasif',
                        'scrapped' => 'Hurda',
                    ])
                    ->label('Durum'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
