<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paiement;
use App\Models\RapportFinancier;
use App\Models\Stock;
use Filament\Notifications\Notification;

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

    // Relations
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

    // 🔹 Hook pour gérer paiements, rapports et stock après création
    protected static function booted()
    {
        static::created(function ($commande) {

            // 1️⃣ Création automatique du paiement
            Paiement::create([
                'commande_id' => $commande->id,
                'client_id' => $commande->client_id,
                'montant' => $commande->prix_total,
                'moyen_paiement' => $commande->moyen_paiement,
                'statut' => 'payé',
            ]);

            // 2️⃣ Création automatique du rapport financier
            RapportFinancier::create([
                'commande_id' => $commande->id,
                'titre' => "Commande n°{$commande->id} de {$commande->client->nom} {$commande->client->prenom}",
                'type' => 'revenu',
                'montant' => $commande->prix_total,
                'date' => $commande->created_at,
                'nom' => $commande->client->nom,
                'prenom' => $commande->client->prenom,
                'adresse' => $commande->client->adresse,
                'photo_article' => optional($commande->photo)->image_path,
                'quantite' => $commande->quantite,
                'prix_achat' => optional($commande->photo)->prix,
            ]);

            // 3️⃣ Décrémentation du stock
            $stock = Stock::where('photo_id', $commande->photo_id)->first();
            if ($stock) {
                $result = $stock->diminuerStock($commande->quantite);

                if (!$result['success']) {
                    throw new \Exception($result['message']);
                }

                // 🔔 Notification si seuil de sécurité atteint
                if ($result['alerte_securite']) {
                    Notification::make()
                        ->title('Alerte Stock')
                        ->body($result['message'])
                        ->warning()
                        ->send();
                }
            }
        });
    }
}
