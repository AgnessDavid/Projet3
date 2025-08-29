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



    // Relation avec les rapports financiers via les commandes
    public function rapportFinanciers()
    {
        return $this->hasManyThrough(
            RapportFinancier::class, // Modèle final
            Commande::class,         // Modèle intermédiaire
            'client_id',             // Foreign key sur commandes
            'commande_id',           // Foreign key sur rapport_financiers
            'id',                    // Local key sur clients
            'id'                     // Local key sur commandes
        );
    }

}
