<?php

namespace App\Filament\Resources\RapportFinanciers\Pages;

use App\Filament\Resources\RapportFinanciers\RapportFinancierResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRapportFinancier extends ViewRecord
{
    protected static string $resource = RapportFinancierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
