<?php
namespace App\Filament\Resources\CommandeResource;

use App\Filament\Resources\Commandes\Pages\CreateCommande;
use App\Filament\Resources\Commandes\Pages\EditCommande;
use App\Filament\Resources\Commandes\Pages\ListCommandes;

use App\Filament\Resources\Commandes\Schemas\CommandeForm;
use App\Filament\Resources\Commandes\Tables\CommandesTable;
use App\Models\Commandes;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

use Filament\Resources\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                    ->dehydrated(false), // pas besoin d'envoyer ce champ, on va le calculer
            ]);


    }



    

    /*    */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('photo.title')->label('Titre de la photo'),
                TextColumn::make('photo.prix')->label('Prix'),
                ImageColumn::make('photo.image_path')->label('Image'),
                TextColumn::make('quantite')->label('Quantité'),
                TextColumn::make('prix_total')->label('Prix total'),
                TextColumn::make('created_at')->label('Commandé le')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
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




