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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            // Liaison directe avec le marché concerné
            $table->foreignId('market_id')->constrained('markets')->onDelete('cascade');
            
            $table->string('nom_candidat');
            $table->string('numero_registre_commerce');
            
            // Stockage de la liste dynamique des matériels au format JSON (comme besoin_matériel)
            $table->text('proposition_technique'); 
            
            // Le montant proposé par le candidat
            $table->decimal('proposition_financiere', 15, 2); 
            
            // Statut de la candidature
            $table->enum('status', ['En attente', 'Accepté', 'Rejeté Automatiquement'])->default('En attente');
            $table->text('motif_statut')->nullable(); // Ex: "Critères techniques non atteints"
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};