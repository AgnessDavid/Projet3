<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $primaryKey = 'id_stock';
    public $timestamps = false;

    protected $fillable = [
        'photo_id',
        'quantite_en_stock',
        'seuil_de_securite',
        'quantite_reapprovisionnement',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    protected static function booted()
    {
        // Quand on crée un nouveau stock
        static::created(function ($stock) {
            $photo = $stock->photo;
            if ($photo) {
                $photo->quantite_en_stock = $photo->quantite_en_stock + $stock->quantite_en_stock;
                $photo->save();
            }
        });

        // Quand on met à jour un stock
        static::updated(function ($stock) {
            $photo = $stock->photo;
            if ($photo) {
                $original = $stock->getOriginal('quantite_en_stock');
                $diff = $stock->quantite_en_stock - $original;
                $photo->quantite_en_stock = $photo->quantite_en_stock + $diff;
                $photo->save();
            }
        });
    }
}
