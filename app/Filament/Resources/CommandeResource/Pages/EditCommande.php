<?php

namespace App\Filament\Resources\Commandes\Pages;

use App\Filament\Resources\CommandeResource;
use Filament\Resources\Pages\EditRecord;

class EditCommande extends EditRecord
{
    protected static string $resource = CommandeResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $photo = \App\Models\Photo::find($data['photo_id']);
        $data['prix_total'] = $photo ? $photo->prix * $data['quantite'] : 0;
        return $data;
    }
}
