<?php

namespace App\Filament\Resources\FicheBesoins\Pages;

use App\Filament\Resources\FicheBesoins\FicheBesoinResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFicheBesoin extends EditRecord
{
    protected static string $resource = FicheBesoinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
