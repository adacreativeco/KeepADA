<?php

namespace App\Filament\Resources\Companies;

use App\Filament\Resources\Companies\Pages\ManageCompanies;
use App\Models\Company;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationLabel = 'Şirketler';
    protected static ?string $pluralLabel = 'Şirketler';
    protected static ?string $modelLabel = 'Şirket';
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Şirket Bilgileri')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Şirket Adı')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->label('URL Uzantısı (Slug)')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),
                    ]),
                Section::make('Abonelik Planı')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('plan')
                                    ->label('Plan')
                                    ->options([
                                        'basics' => 'Başlangıç (1.490 ₺)',
                                        'professional' => 'Profesyonel ⭐ (3.490 ₺)',
                                        'enterprise' => 'Kurumsal (Teklif Al)',
                                    ])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        if ($state === 'basics') {
                                            $set('max_locations', 1);
                                            $set('max_equipment', 50);
                                            $set('max_users', 3);
                                        } elseif ($state === 'professional') {
                                            $set('max_locations', 5);
                                            $set('max_equipment', 9999);
                                            $set('max_users', 10);
                                        } elseif ($state === 'enterprise') {
                                            $set('max_locations', 9999);
                                            $set('max_equipment', 9999);
                                            $set('max_users', 9999);
                                        }
                                    }),
                                DatePicker::make('plan_expires_at')
                                    ->label('Abonelik Bitiş Tarihi'),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('max_locations')
                                    ->label('Maks. Lokasyon')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('max_equipment')
                                    ->label('Maks. Ekipman')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('max_users')
                                    ->label('Maks. Kullanıcı')
                                    ->numeric()
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Şirket Adı')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('plan')
                    ->label('Plan')
                    ->badge()
                    ->colors([
                        'gray' => 'basics',
                        'warning' => 'professional',
                        'success' => 'enterprise',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'basics' => 'Başlangıç',
                        'professional' => 'Profesyonel',
                        'enterprise' => 'Kurumsal',
                    }),
                TextColumn::make('members_count')
                    ->label('Kullanıcı')
                    ->counts('members')
                    ->description(fn ($record) => "Limit: {$record->max_users}"),
                TextColumn::make('locations_count')
                    ->label('Lokasyon')
                    ->counts('locations')
                    ->description(fn ($record) => "Limit: {$record->max_locations}"),
                TextColumn::make('equipment_count')
                    ->label('Ekipman')
                    ->counts('equipment')
                    ->description(fn ($record) => "Limit: {$record->max_equipment}"),
                TextColumn::make('plan_expires_at')
                    ->label('Bitiş')
                    ->date('d.m.Y'),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => ManageCompanies::route('/'),
        ];
    }
}
