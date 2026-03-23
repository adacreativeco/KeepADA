<?php

namespace App\Filament\Resources\MaintenanceTasks\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

use Filament\Forms\Components\Repeater;

class MaintenanceTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Görev Bilgileri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('equipment_id')
                                    ->relationship('equipment', 'name')
                                    ->label('Ekipman')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                Select::make('plan_id')
                                    ->relationship('plan', 'title')
                                    ->label('Bağlı Plan')
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                                TextInput::make('title')
                                    ->label('Görev Başlığı')
                                    ->required()
                                    ->maxLength(255),
                                Select::make('assigned_to')
                                    ->relationship('assignedUser', 'name')
                                    ->label('Atanan Teknisyen')
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ]),
                Section::make('Durum ve Öncelik')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('type')
                                    ->label('Tür')
                                    ->options([
                                        'preventive' => 'Önleyici',
                                        'corrective' => 'Düzeltici',
                                        'emergency' => 'Acil',
                                    ])
                                    ->required(),
                                Select::make('status')
                                    ->label('Durum')
                                    ->options([
                                        'pending' => 'Bekliyor',
                                        'in_progress' => 'Devam Ediyor',
                                        'done' => 'Tamamlandı',
                                        'cancelled' => 'İptal Edildi',
                                    ])
                                    ->required()
                                    ->default('pending'),
                                Select::make('priority')
                                    ->label('Öncelik')
                                    ->options([
                                        'low' => 'Düşük',
                                        'medium' => 'Orta',
                                        'high' => 'Yüksek',
                                        'critical' => 'Kritik',
                                    ])
                                    ->required()
                                    ->default('medium'),
                            ]),
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('scheduled_date')
                                    ->label('Planlanan Tarih')
                                    ->displayFormat('d.m.Y')
                                    ->required(),
                                TextInput::make('actual_cost')
                                    ->label('Parça Maliyeti (₺)')
                                    ->numeric()
                                    ->prefix('₺'),
                                TextInput::make('labor_cost')
                                    ->label('İşçilik Maliyeti (₺)')
                                    ->numeric()
                                    ->prefix('₺'),
                            ]),
                    ]),
                Section::make('Bulgular ve Fotoğraflar')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Teknisyen Notları')
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('before_photos')
                            ->label('Bakım Öncesi Fotoğraflar')
                            ->collection('task_before_photos')
                            ->multiple()
                            ->image(),
                        SpatieMediaLibraryFileUpload::make('after_photos')
                            ->label('Bakım Sonrası Fotoğraflar')
                            ->collection('task_after_photos')
                            ->multiple()
                            ->image(),
                    ]),
            ]);
    }
}
