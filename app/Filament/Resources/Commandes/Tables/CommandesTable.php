<?php

namespace App\Filament\Resources\Commandes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CommandesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('photo.title')->label('Titre de la photo'),
            TextColumn::make('image_path')->label('Titre de la photo'),
            TextColumn::make('photo.prix')->label('Prix unitaire'),
            TextColumn::make('quantite')->label('Quantité'),
            TextColumn::make('prix_total')->label('Prix total'),
            TextColumn::make('created_at')->label('Commandé le')->dateTime(),
        ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


