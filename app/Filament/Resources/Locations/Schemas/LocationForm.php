<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lokasyon Bilgileri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Lokasyon Adı')
                                    ->required()
                                    ->maxLength(255),
                                Toggle::make('is_active')
                                    ->label('Aktif')
                                    ->default(true),
                            ]),
                        Textarea::make('address')
                            ->label('Adres')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('contact_name')
                                    ->label('Yetkili Kişi')
                                    ->maxLength(255),
                                TextInput::make('contact_phone')
                                    ->label('Yetkili Telefon')
                                    ->tel()
                                    ->maxLength(255),
                            ]),
                    ]),
                Section::make('Harita Konumu')
                    ->schema([
                        Map::make('location')
                            ->debug() // Optional: shows data being sent/received
                            ->mapControls([
                                'mapTypeControl'    => true,
                                'scaleControl'      => true,
                                'streetViewControl' => true,
                                'rotateControl'     => true,
                                'fullscreenControl' => true,
                                'searchBoxControl'  => true, // optional
                                'zoomControl'       => true,
                            ])
                            ->height('400px')
                            ->defaultZoom(12)
                            ->autocomplete('address') // map autocomplete from address field
                            ->autocompleteReverse() // address field autocomplete from map location
                            ->latLngField('lat', 'lng') // bind to lat and lng fields
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
