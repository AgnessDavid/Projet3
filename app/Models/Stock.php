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


    public function diminuerStock(int $quantite)
    {
        // Vérifier si la quantité commandée est supérieure au stock
        if ($quantite > $this->quantite_en_stock) {
            return [
                'success' => false,
                'message' => "Quantité commandée ({$quantite}) supérieure au stock disponible ({$this->quantite_en_stock})."
            ];
        }

        // Décrémenter la quantité
        $this->quantite_en_stock -= $quantite;

        // Vérifier le seuil de sécurité
        $alerte_securite = false;
        if ($this->quantite_en_stock < $this->seuil_de_securite) {
            $alerte_securite = true;
        }

        $this->save();

        return [
            'success' => true,
            'alerte_securite' => $alerte_securite,
            'message' => $alerte_securite
                ? "Attention : le stock est inférieur au seuil de sécurité !"
                : "Stock mis à jour avec succès."
        ];
    }

    public function reapprovisionner(int $quantite)
    {
        $this->quantite_en_stock += $quantite;

        // Vérifier si le stock atteint ou dépasse le seuil de sécurité
        $alerte_securite = false;
        if ($this->quantite_en_stock >= $this->seuil_de_securite) {
            $alerte_securite = true;
        }

        $this->save();

        return [
            'success' => true,
            'alerte_securite' => $alerte_securite,
            'message' => $alerte_securite
                ? "Le stock est maintenant suffisant (≥ seuil de sécurité)."
                : "Réapprovisionnement effectué avec succès."
        ];
    }


}
