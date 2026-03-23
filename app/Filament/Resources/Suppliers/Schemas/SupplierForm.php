<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tedarikçi Bilgileri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Tedarikçi Adı')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'Yedek Parça' => 'Yedek Parça',
                                        'Servis' => 'Servis',
                                        'Danışmanlık' => 'Danışmanlık',
                                        'Diğer' => 'Diğer',
                                    ])
                                    ->searchable(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('contact_person')
                                    ->label('Yetkili Kişi')
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Telefon')
                                    ->tel()
                                    ->maxLength(255),
                            ]),
                        TextInput::make('email')
                            ->label('E-posta')
                            ->email()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->label('Adres')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
