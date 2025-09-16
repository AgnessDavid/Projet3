<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Stock;
use Filament\Notifications\Notification;

class Photo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'prix',
        'width',
        'height',
        'quantite_en_stock',
        'quantite_reapprovisionnement',
        'seuil_de_securite',
    ];

    // Historique des mouvements
    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class, 'photo_id');
    }

   
 
}
