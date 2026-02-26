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
        Schema::create('marches', function (Blueprint $table) {
            $table->id();
            // Informations d'identification et de suivi SNGP
            $table->string('ref')->unique(); 
            $table->string('objet');
            $table->enum('procedure', ['AOI', 'AON', 'CF']);
            $table->string('stade')->default('En attente vérif.');
            $table->boolean('is_conforme')->default(false);
            
            // Informations financières et exécution
            $table->decimal('montant', 18, 2)->nullable();
            $table->string('fournisseur')->nullable();
            $table->date('date_lancement')->nullable();
            $table->date('date_attribution')->nullable();
            $table->enum('status', ['en_cours', 'attribue', 'annule'])->default('en_cours');

            // Liaisons
            $table->foreignId('user_id')->constrained(); // Celui qui crée le dossier
            $table->foreignId('project_id')->constrained('projects'); // Le projet lié au marché
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marches');
    }
};