<?php

namespace App\Filament\Resources\FicheBesoins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Table;

class FicheBesoinsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom_structure')->label('Structure')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nom_interlocuteur')->label('Interlocuteur')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('type_structure')->label('Type')->sortable(),
                Tables\Columns\TextColumn::make('date_entretien')->label('Date entretien')->date()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Créée le')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type_structure')
                    ->options([
                        'societe' => 'Société',
                        'organisme' => 'Organisme',
                        'particulier' => 'Particulier',
                    ]),
                Tables\Filters\Filter::make('commande_ferme')
                    ->query(fn($query) => $query->where('commande_ferme', true))
                    ->label('Commandes fermées'),
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
