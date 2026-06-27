<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // ex: PROJ-BAD-001
            $table->string('nom');
            $table->text('description')->nullable();
            
            // Gestion financière multi-devises et allocations
            $table->double('budget_initial', 15, 2); // Montant dans la devise d'origine (ex: 24500000.00)
            $table->string('budget_devise');        // Devise d'origine (USD, EUR, XOF)
            $table->double('budget_value', 15, 2);   // Contre-valeur Pivot convertie en XOF 
            $table->double('taux_change', 10, 2)->nullable(); // Taux figé à la création (ex: 612.50)
            
            // Ventilation du financement (Parts mémorisées en XOF)
            $table->double('financement_bailleur', 15, 2)->nullable(); // Ex: Part BAD
            $table->double('financement_etat', 15, 2)->nullable();     // Ex: Contrepartie ivoirienne
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('taux_execution', 5, 2)->default(0.00);
            $table->string('status')->default('brouillon'); // brouillon, soumis, valide, rejete
            
            // Suivi des acteurs (Créateur UGP & Validateur Direction Nationale)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};