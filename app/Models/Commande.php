<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paiement;
use App\Models\RapportFinancier;

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

    public function rapportFinancier()
    {
        return $this->hasOne(RapportFinancier::class);
    }

    // 🔹 Création auto du paiement & rapport financier
    protected static function booted()
    {
        static::created(function ($commande) {

            // Paiement auto
            Paiement::create([
                'commande_id' => $commande->id,
                'client_id' => $commande->client_id,
                'montant' => $commande->prix_total,
                'moyen_paiement' => $commande->moyen_paiement,
                'statut' => 'payé',
            ]);

            // Rapport financier auto
            RapportFinancier::create([
                'commande_id' => $commande->id,
                'titre' => "Commande n°{$commande->id} de {$commande->client->nom} {$commande->client->prenom}",
                'type' => 'revenu',
                'montant' => $commande->prix_total,
                'date' => $commande->created_at,

                // Infos client
                'nom' => $commande->client->nom,
                'prenom' => $commande->client->prenom,
                'adresse' => $commande->client->adresse,

                // Infos produit
                'photo_article' => optional($commande->photo)->image_path,
                'quantite' => $commande->quantite,
                'prix_achat' => optional($commande->photo)->prix,
            ]);
        });
    }
}
