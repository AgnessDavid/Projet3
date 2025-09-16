<?php

namespace App\Filament\Resources\FicheBesoins;

use App\Filament\Resources\FicheBesoins\Pages\CreateFicheBesoin;
use App\Filament\Resources\FicheBesoins\Pages\EditFicheBesoin;
use App\Filament\Resources\FicheBesoins\Pages\ListFicheBesoins;
use App\Filament\Resources\FicheBesoins\Pages\ViewFicheBesoin;
use App\Filament\Resources\FicheBesoins\Schemas\FicheBesoinForm;
use App\Filament\Resources\FicheBesoins\Schemas\FicheBesoinInfolist;
use App\Filament\Resources\FicheBesoins\Tables\FicheBesoinsTable;
use App\Models\FicheBesoin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FicheBesoinResource extends Resource
{
    protected static ?string $model = FicheBesoin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Fiche de besoins';

    public static function form(Schema $schema): Schema
    {
        return FicheBesoinForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FicheBesoinInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FicheBesoinsTable::configure($table);
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
            'index' => ListFicheBesoins::route('/'),
            'create' => CreateFicheBesoin::route('/create'),
            'view' => ViewFicheBesoin::route('/{record}'),
            'edit' => EditFicheBesoin::route('/{record}/edit'),
        ];
    }
}
