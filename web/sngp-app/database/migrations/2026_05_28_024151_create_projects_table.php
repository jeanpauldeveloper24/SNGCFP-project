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
            
            // Gestion financière multi-devises (Decimal pour la précision comptable)
            $table->decimal('budget_initial', 15, 2); 
            $table->string('budget_devise', 10)->default('XOF'); 
            $table->decimal('budget_value', 15, 2)->default(0.00); // Contre-valeur en XOF
            $table->decimal('taux_change', 10, 4)->default(1.0000); 
            
            // Ventilation du financement (Montants et Pourcentages)
            $table->decimal('financement_bailleur', 15, 2)->nullable(); 
            $table->decimal('financement_etat', 15, 2)->nullable();     
            $table->decimal('pourcentage_bailleur', 5, 2)->nullable(); // Ex: 80.00%
            $table->decimal('pourcentage_etat', 5, 2)->nullable();    // Ex: 20.00%
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('taux_execution', 5, 2)->default(0.00);
            $table->string('status')->default('brouillon'); 
            
            // Relations
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