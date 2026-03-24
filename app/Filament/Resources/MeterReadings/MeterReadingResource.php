<?php

namespace App\Filament\Resources\MeterReadings;

use App\Filament\Resources\MeterReadings\Pages\ManageMeterReadings;
use App\Models\MeterReading;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class MeterReadingResource extends Resource
{
    protected static ?string $model = MeterReading::class;

    protected static ?string $navigationLabel = 'Sayaç Okumaları';
    protected static ?string $pluralLabel = 'Sayaç Okumaları';
    protected static ?string $modelLabel = 'Sayaç Okuması';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-variable';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('equipment_id')
                    ->relationship('equipment', 'name')
                    ->label('Ekipman')
                    ->required()
                    ->searchable()
                    ->preload(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('equipment.name')
                    ->label('Ekipman')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('reading_value')
                    ->label('Değer')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('equipment.meter_unit')
                    ->label('Birim'),
                TextColumn::make('reading_date')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMeterReadings::route('/'),
        ];
    }
}
