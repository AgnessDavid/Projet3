<?php

namespace App\Filament\Resources\Commandes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CommandeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('photo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantite')
                    ->required()
                    ->numeric()
                    ->default(1),
                TextInput::make('prix_total')
                    ->required()
                    ->numeric(),
            ]);
    }
}
