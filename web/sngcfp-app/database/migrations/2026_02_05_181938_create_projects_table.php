<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Identifiant unique (ex: PAIA-2, PTUA)
            $table->string('nom');            // Nom complet du projet
            $table->string('categorie');      // Travaux, Santé, Énergie, etc.
            
            // Utilisation de decimal(15,2) pour gérer les milliards de FCFA avec précision
            $table->decimal('budget_alloue', 15, 2); 
            $table->decimal('budget_depense', 15, 2)->default(0);
            $table->decimal('fonds_recus_bad', 15, 2)->default(0);
            
            $table->integer('taux_execution')->default(0); // Pourcentage (0 à 100)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};