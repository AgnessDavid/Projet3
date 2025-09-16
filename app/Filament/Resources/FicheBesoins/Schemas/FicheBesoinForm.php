<?php

namespace App\Filament\Resources\FicheBesoins\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class FicheBesoinForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Infos structure / interlocuteur
                TextInput::make('nom_structure')->label('Nom structure'),
                Select::make('type_structure')
                    ->options([
                        'societe' => 'Société',
                        'organisme' => 'Organisme',
                        'particulier' => 'Particulier',
                    ])
                    ->label('Type structure'),
                TextInput::make('nom_interlocuteur')->label('Nom interlocuteur'),
                TextInput::make('fonction')->label('Fonction'),

                // Contacts
                TextInput::make('telephone')->label('Téléphone'),
                TextInput::make('cellulaire')->label('Cellulaire'),
                TextInput::make('fax')->label('Fax'),
                TextInput::make('email')->label('Email'),

                // Entretien
                TextInput::make('nom_agent_bnetd')->label('Agent BNETD'),
                DatePicker::make('date_entretien')->label('Date entretien'),

                // Options
                Toggle::make('commande_ferme')->label('Commande fermée'),
                Toggle::make('demande_facture_proforma')->label('Demande facture proforma'),

                // Livraison
                DatePicker::make('date_livraison_prevue')->label('Date livraison prévue'),
                DatePicker::make('date_livraison_reelle')->label('Date livraison réelle'),
                TextInput::make('delai_souhaite')->label('Délai souhaité'),

                // Signatures
                TextInput::make('signature_client')->label('Signature client'),
                TextInput::make('signature_agent_bnetd')->label('Signature agent'),

                // Repeater pour besoins exprimés (JSON)
                Repeater::make('besoins_exprimes')
                    ->label('Besoins exprimés')
                    ->schema([
                        TextInput::make('besoin')->label('Besoins'),
                        TextInput::make('objectif_vise')->label('Objectif visé'),
                    ])
                    ->columns(2),
            ]);
    }
}
