<?php

namespace App\Filament\Resources\FicheBesoins\Pages;

use App\Filament\Resources\FicheBesoins\FicheBesoinResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFicheBesoin extends ViewRecord
{
    protected static string $resource = FicheBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
