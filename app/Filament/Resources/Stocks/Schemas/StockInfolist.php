<?php

namespace App\Filament\Resources\Stocks\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('photo_id')
                    ->numeric(),
                TextEntry::make('quantite_en_stock')
                    ->numeric(),
                TextEntry::make('seuil_de_securite')
                    ->numeric(),
                TextEntry::make('quantite_reapprovisionnement')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
