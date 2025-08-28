<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nom')
                    ->required(),
                TextInput::make('prenom')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('telephone')
                    ->tel()
                    ->required(),
                TextInput::make('adresse')
                    ->required(),
            ]);
    }
}
