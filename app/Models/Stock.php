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

}
