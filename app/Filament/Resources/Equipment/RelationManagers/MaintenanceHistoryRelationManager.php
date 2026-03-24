<?php

namespace App\Filament\Resources\Equipment\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceHistoryRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenanceHistory';

    protected static ?string $title = 'Bakım Geçmişi';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Read-only view genelde history için daha iyidir
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'done'))
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Görev Başlığı')
                    ->searchable(),
                TextColumn::make('completed_at')
                    ->label('Tamamlanma Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->label('Teknisyen'),
                TextColumn::make('total_cost')
                    ->label('Toplam Maliyet')
                    ->money('try'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // History olduğu için ekleme yok
            ])
            ->recordActions([
                \Filament\Tables\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
