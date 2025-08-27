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
    ];



    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    

}
