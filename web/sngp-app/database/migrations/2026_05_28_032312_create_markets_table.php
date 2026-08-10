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
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reference')->nullable()->unique();
            $table->string('objet');
            
            // Clés étrangères
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('project_module_id')->nullable()->constrained('project_modules')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Titulaire / Prestataire
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // Agent créateur
            
            // Procédure & Étape
            $table->string('methode_passation')->nullable(); // Ex: AON, AOI, AOR, COTA
            $table->string('etape')->default('EXPRESSION_BESOIN');
            $table->enum('status', ['Non attribué', 'Attribution en cour', 'Attribué'])->default('Non attribué');

            // Cahier des charges & Financement
            $table->decimal('besoin_financier', 15, 2)->default(0.00);
            $table->string('devise', 10)->default('FCFA');
            $table->json('besoins_materiels')->nullable();

            // Chronogramme de candidature uniquement
            $table->date('candidature_start_date')->nullable();
            $table->date('candidature_end_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};