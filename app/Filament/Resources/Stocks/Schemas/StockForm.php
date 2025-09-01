<?php

namespace App\Filament\Resources\Stocks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('photo_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantite_en_stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('seuil_de_securite')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quantite_reapprovisionnement')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
