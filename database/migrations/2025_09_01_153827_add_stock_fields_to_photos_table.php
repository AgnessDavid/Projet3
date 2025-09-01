<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->integer('quantite_en_stock')->default(0);
            $table->integer('seuil_de_securite')->default(0);
            $table->integer('quantite_reapprovisionnement')->default(0);
           
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['quantite_en_stock', 'seuil_de_securite', 'quantite_reapprovisionnement']);
        });
    }

};
