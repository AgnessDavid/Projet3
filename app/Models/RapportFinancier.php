<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportFinancier extends Model
{
    use HasFactory;

    protected $fillable = [
        'commande_id',
        'titre',
        'type',
        'montant',
        'date',
        'nom',
        'prenom',
        'adresse',
        'photo_article',
        'quantite',
        'prix_achat',
    ];

    protected $casts = [
        'date' => 'date',
        'montant' => 'decimal:2',
    ];

    // Relation avec la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Relation avec le client (via la commande)
    public function client()
    {
        return $this->belongsToThrough(Client::class, Commande::class);
    }

    // Relation avec la photo de l'article (via la commande)
    public function photoArticle()
    {
        return $this->belongsToThrough(Photo::class, Commande::class);
    }
}
