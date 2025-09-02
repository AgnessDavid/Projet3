<?php

namespace App\Filament\Resources\Commandes\Pages;

use App\Filament\Resources\Commandes\CommandeResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Stock;
use Filament\Notifications\Notification;

class CreateCommande extends CreateRecord
{
    protected static string $resource = CommandeResource::class;

    // 🔹 Vérification du stock avant création
    protected function beforeCreate(): void
    {
        $stock = Stock::where('photo_id', $this->data['photo_id'])->first();

        if ($stock && $this->data['quantite'] > $stock->quantite_en_stock) {
            Notification::make()
                ->title('Stock insuffisant')
                ->body("La quantité commandée ({$this->data['quantite']}) dépasse le stock disponible ({$stock->quantite_en_stock}).")
                ->danger()
                ->send();

            // Bloque la création
            $this->halt(); // Filament 4 : stoppe la création sans lancer d'exception
        }
    }
    // 🔹 Redirection après création
    protected function afterCreate(): void
    {
        $this->redirect($this->getResource()::getUrl('edit', [
            'record' => $this->record->getKey(),
        ]));
    }
}
