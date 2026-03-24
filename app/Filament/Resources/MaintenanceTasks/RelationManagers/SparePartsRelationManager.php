<?php

namespace App\Filament\Resources\MaintenanceTasks\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SparePartsRelationManager extends RelationManager
{
    protected static string $relationship = 'spareParts';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Parça Adı')
                    ->required()
                    ->maxLength(255),
                TextInput::make('quantity_used')
                    ->label('Kullanılan Miktar')
                    ->numeric()
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Parça Adı')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Stok Kodu'),
                TextColumn::make('quantity_used')
                    ->label('Miktar')
                    ->numeric(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer'))
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('quantity_used')
                            ->label('Miktar')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ])
                    ->after(function (array $data) {
                        $sparePart = \App\Models\SparePart::find($data['recordId']);
                        if ($sparePart) {
                            $sparePart->adjustStock($data['quantity_used'], 'out', $this->getOwnerRecord()->id, 'Bakım görevi için kullanıldı');
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer'))
                    ->form(fn (EditAction $action): array => [
                        TextInput::make('quantity_used')
                            ->label('Miktar')
                            ->numeric()
                            ->required(),
                    ])
                    ->before(function (\App\Models\SparePart $record, array $data) {
                        $oldQuantity = $record->pivot->quantity_used;
                        $newQuantity = $data['quantity_used'];
                        $diff = $newQuantity - $oldQuantity;
                        
                        if ($diff != 0) {
                            $type = $diff > 0 ? 'out' : 'in';
                            $record->adjustStock(abs($diff), $type, $this->getOwnerRecord()->id, 'Bakım görevi miktarı güncellendi');
                        }
                    }),
                DetachAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer'))
                    ->before(function (\App\Models\SparePart $record) {
                        $record->adjustStock($record->pivot->quantity_used, 'in', $this->getOwnerRecord()->id, 'Bakım görevinden parça çıkarıldı');
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->hidden(fn () => auth()->user()->hasRole('viewer')),
                    DeleteBulkAction::make()
                        ->hidden(fn () => auth()->user()->hasRole('viewer')),
                ]),
            ]);
    }
}
