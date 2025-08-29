<?php

namespace App\Filament\Resources\RapportFinanciers\Pages;

use App\Filament\Resources\RapportFinanciers\RapportFinancierResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRapportFinancier extends EditRecord
{
    protected static string $resource = RapportFinancierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
