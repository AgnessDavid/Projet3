<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fiches_besoin', function (Blueprint $table) {
            $table->id();

            // Infos structure / interlocuteur
            $table->string('nom_structure')->nullable();
            $table->enum('type_structure', ['societe', 'organisme', 'particulier'])->nullable();
            $table->string('nom_interlocuteur')->nullable();
            $table->string('fonction')->nullable();

            // Contacts
            $table->string('telephone')->nullable();
            $table->string('cellulaire')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();

            // Entretien
            $table->string('nom_agent_bnetd')->nullable();
            $table->date('date_entretien')->nullable();

            // Options
            $table->boolean('commande_ferme')->default(false);
            $table->boolean('demande_facture_proforma')->default(false);

            // Livraison
            $table->date('date_livraison_prevue')->nullable();
            $table->date('date_livraison_reelle')->nullable();
            $table->string('delai_souhaite')->nullable();

            // Signatures
            $table->string('signature_client')->nullable();
            $table->string('signature_agent_bnetd')->nullable();

            // Besoins exprimés et objectifs
            $table->json('besoins_exprimes')->nullable();
            // Exemple de contenu JSON :
            // [
            //   {"besoin":"Besoin 1", "objectif_vise":"Objectif 1"},
            //   {"besoin":"Besoin 2", "objectif_vise":"Objectif 2"}
            // ]

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fiches_besoin');
    }
};
