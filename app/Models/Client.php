<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
    ];



    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }



    // Relation avec les commandes
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
