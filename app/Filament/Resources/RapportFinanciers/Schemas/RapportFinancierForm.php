<?php

namespace App\Filament\Resources\RapportFinanciers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RapportFinancierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('commande_id')
                    ->required()
                    ->numeric(),
                TextInput::make('titre')
                    ->required(),
                Select::make('type')
                    ->options(['revenu' => 'Revenu'])
                    ->required(),
                TextInput::make('montant')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('nom')
                    ->required(),
                TextInput::make('prenom')
                    ->required(),
                TextInput::make('adresse')
                    ->required(),
                TextInput::make('photo_article'),
                TextInput::make('quantite')
                    ->required()
                    ->numeric(),
                TextInput::make('prix_achat')
                    ->required()
                    ->numeric(),
            ]);
    }
}
