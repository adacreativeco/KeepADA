<?php

namespace App\Filament\Resources\Equipment\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeterReadingsRelationManager extends RelationManager
{
    protected static string $relationship = 'meterReadings';
    protected static ?string $title = 'Sayaç Okumaları';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reading_value')
                    ->label('Sayaç Değeri')
                    ->numeric()
                    ->required(),
                DateTimePicker::make('reading_date')
                    ->label('Okuma Tarihi')
                    ->default(now())
                    ->required(),
                Textarea::make('notes')
                    ->label('Notlar')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reading_value')
            ->columns([
                TextColumn::make('reading_value')
                    ->label('Değer')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reading_date')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('notes')
                    ->label('Notlar')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
