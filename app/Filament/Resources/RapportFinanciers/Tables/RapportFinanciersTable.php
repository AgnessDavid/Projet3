<?php

namespace App\Filament\Resources\RapportFinanciers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RapportFinanciersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('commande_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('titre')
                    ->searchable(),
                TextColumn::make('type'),
                TextColumn::make('montant')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('nom')
                    ->searchable(),
                TextColumn::make('prenom')
                    ->searchable(),
                TextColumn::make('adresse')
                    ->searchable(),
                TextColumn::make('photo_article')
                    ->searchable(),
                TextColumn::make('quantite')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('prix_achat')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
