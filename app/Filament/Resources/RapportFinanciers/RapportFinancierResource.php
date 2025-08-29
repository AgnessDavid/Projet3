<?php

namespace App\Filament\Resources\RapportFinanciers;

use App\Filament\Resources\RapportFinanciers\Pages\CreateRapportFinancier;
use App\Filament\Resources\RapportFinanciers\Pages\EditRapportFinancier;
use App\Filament\Resources\RapportFinanciers\Pages\ListRapportFinanciers;
use App\Filament\Resources\RapportFinanciers\Pages\ViewRapportFinancier;
use App\Filament\Resources\RapportFinanciers\Schemas\RapportFinancierForm;
use App\Filament\Resources\RapportFinanciers\Schemas\RapportFinancierInfolist;
use App\Filament\Resources\RapportFinanciers\Tables\RapportFinanciersTable;
use App\Models\RapportFinancier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RapportFinancierResource extends Resource
{
    protected static ?string $model = RapportFinancier::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Rapport Financier';

    public static function form(Schema $schema): Schema
    {
        return RapportFinancierForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RapportFinancierInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RapportFinanciersTable::configure($table);
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
            'index' => ListRapportFinanciers::route('/'),
            'create' => CreateRapportFinancier::route('/create'),
            'view' => ViewRapportFinancier::route('/{record}'),
            'edit' => EditRapportFinancier::route('/{record}/edit'),
        ];
    }
}
