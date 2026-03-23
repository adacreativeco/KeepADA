<?php

namespace App\Filament\Resources\MaintenancePlans\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class MaintenancePlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Plan Detayları')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('equipment_id')
                                    ->relationship('equipment', 'name')
                                    ->label('Ekipman')
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('title')
                                    ->label('Bakım Başlığı')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Textarea::make('description')
                            ->label('Açıklama / Yapılacaklar')
                            ->columnSpanFull(),
                    ]),
                Section::make('Periyot ve Maliyet')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('frequency_type')
                                    ->label('Periyot Tipi')
                                    ->options([
                                        'daily' => 'Günlük',
                                        'weekly' => 'Haftalık',
                                        'monthly' => 'Aylık',
                                        'quarterly' => 'Üç Aylık',
                                        'yearly' => 'Yıllık',
                                        'custom' => 'Özel',
                                    ])
                                    ->required(),
                                TextInput::make('frequency_value')
                                    ->label('Periyot Değeri')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('estimated_duration_minutes')
                                    ->label('Tahmini Süre (Dakika)')
                                    ->numeric(),
                                TextInput::make('estimated_cost')
                                    ->label('Tahmini Maliyet (₺)')
                                    ->numeric()
                                    ->prefix('₺'),
                                TextInput::make('sla_hours')
                                    ->label('SLA Süresi (Saat)')
                                    ->numeric()
                                    ->suffix('saat'),
                                Select::make('assigned_to')
                                    ->relationship('assignedUser', 'name')
                                    ->label('Sorumlu Teknisyen')
                                    ->searchable()
                                    ->preload(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('next_due_date')
                                    ->label('Sonraki Bakım Tarihi')
                                    ->displayFormat('d.m.Y')
                                    ->required(),
                                Toggle::make('is_active')
                                    ->label('Aktif Plan')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }
}
