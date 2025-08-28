<?php

namespace App\Filament\Resources\Paiements\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaiementInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('commande_id')
                    ->numeric(),
                TextEntry::make('client_id')
                    ->numeric(),
                TextEntry::make('montant')
                    ->numeric(),
                TextEntry::make('moyen_paiement'),
                TextEntry::make('statut'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
