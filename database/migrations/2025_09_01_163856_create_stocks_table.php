<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id('id_stock');

            // Relation vers la table des produits ou cartes
            $table->foreignId('produit_id')->constrained('produits')->onDelete('cascade');

            $table->integer('quantite_en_stock')->default(0);
            $table->integer('seuil_de_securite')->default(0);
            $table->integer('quantite_reapprovisionnement')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
