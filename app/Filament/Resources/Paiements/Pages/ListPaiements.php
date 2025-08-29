<?php

namespace App\Filament\Resources\Paiements\Pages;

use App\Filament\Resources\Paiements\PaiementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
/*
use App\Filament\Widgets\RapportFinancier;
*/

class ListPaiements extends ListRecords
{
    protected static string $resource = PaiementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

 /*
   protected function getHeaderWidgets(): array 
      {


return[ RapportFinancier::class,



];

   }

*/
}



