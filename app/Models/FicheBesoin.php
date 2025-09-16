<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FicheBesoin extends Model
{
    use HasFactory;

    protected $table = 'fiches_besoin';

    protected $fillable = [
        'nom_structure',
        'type_structure',
        'nom_interlocuteur',
        'fonction',
        'telephone',
        'cellulaire',
        'fax',
        'email',
        'nom_agent_bnetd',
        'date_entretien',
        'commande_ferme',
        'demande_facture_proforma',
        'date_livraison_prevue',
        'date_livraison_reelle',
        'delai_souhaite',
        'signature_client',
        'signature_agent_bnetd',
        'besoins_exprimes',
    ];

    // Cast JSON en tableau PHP automatiquement
    protected $casts = [
        'besoins_exprimes' => 'array',
        'commande_ferme' => 'boolean',
        'demande_facture_proforma' => 'boolean',
        'date_entretien' => 'date',
        'date_livraison_prevue' => 'date',
        'date_livraison_reelle' => 'date',
    ];
}
