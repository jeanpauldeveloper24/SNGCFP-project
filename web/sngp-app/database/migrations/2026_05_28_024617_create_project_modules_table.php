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
        Schema::create('project_modules', function (Blueprint $table) {
            $table->id();
            
            // Liaison sacrée avec le projet parent
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            
            // Structure de tes modules
            $table->integer('number'); // ex: Module 1, Module 2
            $table->text('description')->nullable();
            $table->double('budget_value', 15, 2);
            $table->string('budget_devise'); // 'FCFA' ou 'USD'
            $table->string('duree')->nullable(); // ex: '6 mois', '1 an'
            
            $table->string('status')->default('Non débuté'); // Pour le suivi d'avancement
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_modules');
    }
};