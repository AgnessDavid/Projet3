<?php

namespace App\Filament\Resources\Commandes;

use App\Filament\Resources\Commandes\Pages\CreateCommande;
use App\Filament\Resources\Commandes\Pages\EditCommande;
use App\Filament\Resources\Commandes\Pages\ListCommandes;
use App\Filament\Resources\Commandes\Schemas\CommandeForm;
use App\Filament\Resources\Commandes\Tables\CommandesTable;
use App\Models\Commande;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use App\Models\Photo;

class CommandeResource extends Resource
{
    protected static ?string $model = Commande::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Commande';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('photo_id')
                    ->label('Photo')
                    ->options(Photo::all()->pluck('title', 'id'))
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Récupère le prix de la photo sélectionnée
                        $photo = Photo::find($state);
                        $set('prix_total', $photo ? $photo->prix : 0);
                    }),

                TextInput::make('quantite')
                    ->label('Quantité')
                    ->numeric()
                    ->default(1)
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        // Recalcule le prix total quand la quantité change
                        $photoId = $get('photo_id');
                        $photo = Photo::find($photoId);
                        if ($photo) {
                            $set('prix_total', $state * $photo->prix);
                        }
                    }),

                TextInput::make('prix_total')
                    ->label('Prix total')
                    ->disabled()
                    ->dehydrated() // doit être sauvegardé dans la base
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return CommandesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommandes::route('/'),
            'create' => CreateCommande::route('/create'),
            'edit' => EditCommande::route('/{record}/edit'),
        ];
    }
}
