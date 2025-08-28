<?php

namespace App\Filament\Resources\Commandes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ViewAction;









class CommandesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('photo.title')->label('Titre de la photo'),
                ImageColumn::make('photo.image_path')
                    ->label('Photo'),
                     // optionnel pour arrondir les coins
            TextColumn::make('photo.prix')->label('Prix unitaire'),
            TextColumn::make('quantite')->label('Quantité'),
            TextColumn::make('prix_total')->label('Prix total'),
            TextColumn::make('client.nom')->label('Client'),
            TextColumn::make('moyen_paiement'),
            TextColumn::make('created_at')->label('Commandé le')->dateTime(),
        ])
            ->filters([
                //
            ])


            ->actions([
                EditAction::make(),
              
            ])

            ->recordActions([
                EditAction::make(),
                ViewAction::make('Voir')
                   
                    
                  
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}


