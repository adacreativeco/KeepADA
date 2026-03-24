<?php

namespace App\Filament\Resources\SpareParts\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockTransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockTransactions';
    protected static ?string $title = 'Stok Hareketleri';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Hareket Türü')
                    ->options([
                        'in' => 'Giriş (Stok Ekleme)',
                        'out' => 'Çıkış (Kullanım)',
                        'adjustment' => 'Düzeltme',
                    ])
                    ->required(),
                TextInput::make('quantity')
                    ->label('Miktar')
                    ->numeric()
                    ->required(),
                Textarea::make('notes')
                    ->label('Notlar')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'in' => 'success',
                        'out' => 'danger',
                        'adjustment' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'in' => 'Giriş',
                        'out' => 'Çıkış',
                        'adjustment' => 'Düzeltme',
                    }),
                TextColumn::make('quantity')
                    ->label('Miktar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('İşlemi Yapan'),
                TextColumn::make('task.title')
                    ->label('Bağlı Görev')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Relation manager üzerinden ekleme yaparken SparePart::adjustStock kullanılmalı
                // Bu yüzden buradaki CreateAction'ı özelleştiriyoruz
                \Filament\Actions\CreateAction::make()
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->adjustStock(
                            $data['quantity'],
                            $data['type'],
                            null,
                            $data['notes']
                        );
                    }),
            ])
            ->recordActions([
                \Filament\Tables\Actions\ViewAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
