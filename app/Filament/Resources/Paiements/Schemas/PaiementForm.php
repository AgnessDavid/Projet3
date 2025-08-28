<?php

namespace App\Filament\Resources\Paiements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaiementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('commande_id')
                    ->required()
                    ->numeric(),
                TextInput::make('client_id')
                    ->required()
                    ->numeric(),
                TextInput::make('montant')
                    ->required()
                    ->numeric(),
                TextInput::make('moyen_paiement')
                    ->required(),
                Select::make('statut')
                    ->options(['en_attente' => 'En attente', 'payé' => 'Payé', 'annulé' => 'Annulé'])
                    ->default('en_attente')
                    ->required(),
            ]);
    }
}
