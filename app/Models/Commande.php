<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo_id',
        'quantite',
        'prix_total',
        'client_id',
        'moyen_paiement',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    // 🔹 Ajout automatique du paiement après création
    protected static function booted()
    {
        static::created(function ($commande) {
            \App\Models\Paiement::create([
                'commande_id' => $commande->id,
                'client_id' => $commande->client_id,
                'montant' => $commande->prix_total,
                'moyen_paiement' => $commande->moyen_paiement,
                'statut' => 'en attente', // ou 'payé'
            ]);
        });
    }
}
