<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            // 1️⃣ Ajouter la colonne client_id nullable
            if (!Schema::hasColumn('commandes', 'client_id')) {
                $table->foreignId('client_id')->nullable()->after('id');
            }

            // 2️⃣ Ajouter le moyen de paiement
            if (!Schema::hasColumn('commandes', 'moyen_paiement')) {
                $table->string('moyen_paiement')->after('prix_total');
            }
        });

        // 3️⃣ Remplir client_id pour les commandes existantes (par exemple avec le client id = 1)
        DB::table('commandes')->update(['client_id' => 1]);

        // 4️⃣ Ajouter la contrainte étrangère après avoir rempli les données
        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['client_id']);
            $table->dropColumn(['client_id', 'moyen_paiement']);
        });
    }
};
