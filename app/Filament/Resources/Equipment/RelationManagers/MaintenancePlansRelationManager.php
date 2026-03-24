<?php

namespace App\Filament\Resources\Equipment\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaintenancePlansRelationManager extends RelationManager
{
    protected static string $relationship = 'MaintenancePlans';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
                AssociateAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
            ])
            ->recordActions([
                EditAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
                DissociateAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
                DeleteAction::make()
                    ->hidden(fn () => auth()->user()->hasRole('viewer')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make()
                        ->hidden(fn () => auth()->user()->hasRole('viewer')),
                    DeleteBulkAction::make()
                        ->hidden(fn () => auth()->user()->hasRole('viewer')),
                ]),
            ]);
    }
}
