<?php

namespace App\Filament\Resources\Photos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;

class PhotoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('prix')
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
               
                TextInput::make('width')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('height')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('quantite_en_stock')
                    ->numeric()
                    ->minValue(0),
               
                FileUpload::make('image_path')
                    ->image()
                    ->required(),
            ]);
    }
}
