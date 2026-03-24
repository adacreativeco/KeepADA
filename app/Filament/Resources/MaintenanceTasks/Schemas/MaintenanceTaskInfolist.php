<?php

namespace App\Filament\Resources\MaintenanceTasks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Schemas\Schema;

class MaintenanceTaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Görev Özeti')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('title')->label('Başlık'),
                                TextEntry::make('equipment.name')->label('Ekipman'),
                                TextEntry::make('status')
                                    ->label('Durum')
                                    ->badge()
                                    ->colors([
                                        'gray' => 'pending',
                                        'info' => 'in_progress',
                                        'success' => 'done',
                                        'danger' => 'cancelled',
                                    ]),
                            ]),
                    ]),
                Section::make('Bulgular ve Notlar')
                    ->schema([
                        TextEntry::make('notes')
                            ->label('Teknisyen Notları')
                            ->columnSpanFull()
                            ->placeholder('Not eklenmemiş.'),
                    ]),
                Section::make('Maliyet Detayları')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextEntry::make('actual_cost')
                                    ->label('Parça Maliyeti')
                                    ->money('try'),
                                TextEntry::make('labor_cost')
                                    ->label('İşçilik Maliyeti')
                                    ->money('try'),
                                TextEntry::make('material_cost')
                                    ->label('Ek Malzeme')
                                    ->money('try'),
                                TextEntry::make('total_cost')
                                    ->label('Toplam Maliyet')
                                    ->money('try')
                                    ->weight('bold')
                                    ->color('success'),
                            ]),
                    ]),
                Section::make('Fotoğraflar')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryImageEntry::make('before_photos')
                                    ->label('Bakım Öncesi')
                                    ->collection('task_before_photos'),
                                SpatieMediaLibraryImageEntry::make('after_photos')
                                    ->label('Bakım Sonrası')
                                    ->collection('task_after_photos'),
                            ]),
                    ]),
            ]);
    }
}