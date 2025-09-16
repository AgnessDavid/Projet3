<?php

namespace App\Filament\Resources\FicheBesoins\Pages;

use App\Filament\Resources\FicheBesoins\FicheBesoinResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFicheBesoins extends ListRecords
{
    protected static string $resource = FicheBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
