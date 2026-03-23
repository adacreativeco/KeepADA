<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Schemas\Schema;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;

use Filament\Infolists\Components\ImageEntry;

class EquipmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Ekipman Detayları')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')->label('Ekipman Adı'),
                                TextEntry::make('code')->label('Ekipman Kodu'),
                                ImageEntry::make('qr_link')
                                    ->label('QR Kod')
                                    ->default(fn ($record) => "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . url("/e/" . ($record->qr_code ?: $record->code)))
                                    ->extraImgAttributes(['style' => 'width: 150px; height: 150px;']),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('location.name')->label('Lokasyon'),
                                TextEntry::make('supplier.name')->label('Tedarikçi'),
                                TextEntry::make('status')
                                    ->label('Durum')
                                    ->badge()
                                    ->colors([
                                        'success' => 'active',
                                        'warning' => 'passive',
                                        'danger' => 'scrapped',
                                    ]),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('warranty_end_date')
                                    ->label('Garanti Bitiş')
                                    ->date('d.m.Y'),
                                TextEntry::make('predictive_next_due_date')
                                    ->label('Tahmini Bakım Tarihi')
                                    ->date('d.m.Y')
                                    ->color('info')
                                    ->weight('bold'),
                            ]),
                    ]),
                Section::make('Fotoğraflar')
                    ->schema([
                        SpatieMediaLibraryImageEntry::make('photos')
                            ->label('Ekipman Fotoğrafları')
                            ->collection('equipment_photos')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
