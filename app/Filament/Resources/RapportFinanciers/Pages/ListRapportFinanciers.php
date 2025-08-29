<?php

namespace App\Filament\Resources\RapportFinanciers\Pages;

use App\Filament\Resources\RapportFinanciers\RapportFinancierResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRapportFinanciers extends ListRecords
{
    protected static string $resource = RapportFinancierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
