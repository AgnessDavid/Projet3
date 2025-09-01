<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demandes_impression', function (Blueprint $table) {
            $table->id('id_demande_impression');
            $table->dateTime('date_demande');
            $table->integer('quantite_demandee');
            $table->string('statut_demande');
            $table->foreignId('id_produit')->constrained('produits');
            $table->foreignId('id_employe_demandeur')->constrained('employes', 'id_employe');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demandes_impression');
    }
};
