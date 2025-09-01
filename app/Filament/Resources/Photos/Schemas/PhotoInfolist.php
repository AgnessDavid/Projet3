<?php

namespace App\Filament\Resources\Photos\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BooleanEntry;
use Filament\Schemas\Schema;

class PhotoInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description'),
                TextEntry::make('prix'),
                TextEntry::make('width'),
                TextEntry::make('height'),
                TextEntry::make('quantite_en_stock'),
               
                ImageEntry::make('image_path'),
                TextEntry::make('created_at')->dateTime(),
                TextEntry::make('updated_at')->dateTime(),
            ]);
    }
}
