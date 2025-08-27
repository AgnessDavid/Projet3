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
                ->options(\App\Models\Photo::all()->pluck('title', 'id'))
                ->reactive()
                ->required(),

            TextInput::make('quantite')
                ->label('Quantité')
                ->numeric()
                ->default(1)
                ->reactive()
                ->required(),

            TextInput::make('prix_total')
                ->label('Prix total')
                ->disabled()
                ->default(0)
                ->dehydrated(false), // ne pas sauvegarder directement
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
