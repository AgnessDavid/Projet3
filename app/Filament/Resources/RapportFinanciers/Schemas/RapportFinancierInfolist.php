<?php

namespace App\Filament\Resources\RapportFinanciers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RapportFinancierInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('commande_id')
                    ->numeric(),
                TextEntry::make('titre'),
                TextEntry::make('type'),
                TextEntry::make('montant')
                    ->numeric(),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('nom'),
                TextEntry::make('prenom'),
                TextEntry::make('adresse'),
                TextEntry::make('photo_article'),
                TextEntry::make('quantite')
                    ->numeric(),
                TextEntry::make('prix_achat')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
