<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'seuil_de_securite',
        'quantite_reapprovisionnement',
        
    ];

    // Relation inverse vers le stock
    public function stock()
    {
        return $this->hasOne(Stock::class, 'photo_id');
    }
}
