<?php
namespace App\Filament\Resources\CommandeResource\Pages;

use App\Filament\Resources\CommandeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCommande extends CreateRecord
{
    protected static string $resource = CommandeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Calcul automatique du prix total
        $photo = \App\Models\Photo::find($data['photo_id']);
        $data['prix_total'] = $photo ? $photo->prix * $data['quantite'] : 0;
        return $data;
    }
}
