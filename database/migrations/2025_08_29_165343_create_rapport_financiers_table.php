<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rapport_financiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained()->cascadeOnDelete();
            $table->string('titre');
            $table->enum('type', ['revenu']);
            $table->decimal('montant', 15, 2);
            $table->date('date');
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse');
            $table->string('photo_article')->nullable();
            $table->integer('quantite');
            $table->decimal('prix_achat', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rapport_financiers');
    }
};
