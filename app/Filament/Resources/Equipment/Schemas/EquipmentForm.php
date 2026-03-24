<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Temel Bilgiler')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('location_id')
                                    ->relationship('location', 'name')
                                    ->label('Lokasyon')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Select::make('supplier_id')
                                    ->relationship('supplier', 'name')
                                    ->label('Tedarikçi')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('name')
                                    ->label('Ekipman Adı')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('code')
                                    ->label('Ekipman Kodu')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('qr_code')
                                    ->label('QR Kodu')
                                    ->maxLength(255),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'Elektrik' => 'Elektrik',
                                        'Mekanik' => 'Mekanik',
                                        'HVAC' => 'HVAC',
                                        'Asansör' => 'Asansör',
                                        'Jeneratör' => 'Jeneratör',
                                        'Diğer' => 'Diğer',
                                    ])
                                    ->searchable(),
                                TextInput::make('brand')
                                    ->label('Marka')
                                    ->maxLength(255),
                                TextInput::make('model')
                                    ->label('Model')
                                    ->maxLength(255),
                            ]),
                    ]),
                Section::make('Teknik Detaylar')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('serial_number')
                                    ->label('Seri Numarası')
                                    ->maxLength(255),
                                DatePicker::make('purchase_date')
                                    ->label('Satın Alma Tarihi')
                                    ->displayFormat('d.m.Y'),
                                DatePicker::make('warranty_end_date')
                                    ->label('Garanti Bitiş Tarihi')
                                    ->displayFormat('d.m.Y'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('current_meter_reading')
                                    ->label('Güncel Sayaç Değeri')
                                    ->numeric()
                                    ->default(0),
                                TextInput::make('meter_unit')
                                    ->label('Sayaç Birimi (ör: Saat, Km)')
                                    ->placeholder('Saat, Km vb.')
                                    ->maxLength(255),
                            ]),
                        Select::make('status')
                            ->label('Durum')
                            ->options([
                                'active' => 'Aktif',
                                'passive' => 'Pasif',
                                'scrapped' => 'Hurda',
                            ])
                            ->required()
                            ->default('active'),
                        RichEditor::make('notes')
                            ->label('Notlar')
                            ->columnSpanFull(),
                    ]),
                Section::make('Fotoğraflar')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('photos')
                            ->label('Ekipman Fotoğrafları')
                            ->collection('equipment_photos')
                            ->multiple()
                            ->image()
                            ->reorderable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
