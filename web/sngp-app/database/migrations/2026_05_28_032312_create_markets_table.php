<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('markets', function (Blueprint $table) {
        $table->id();
        
        // Clés étrangères d'appartenance
        $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
        $table->foreignId('project_module_id')->nullable()->constrained('project_modules')->onDelete('cascade');
        
        $table->string('objet'); 
        $table->text('besoins_materiels')->nullable();
        $table->double('montant', 15, 2); 
        $table->string('devise')->default('FCFA');
        
        $table->date('date_lancement')->nullable(); 
        $table->date('date_attribution')->nullable(); 
        $table->date('candidature_start_date')->nullable();
        $table->date('candidature_end_date')->nullable();
        
        $table->string('status')->default('En cours'); 
        $table->string('etape')->default('EXPRESSION_BESOIN'); 
        
        // Critères administratifs
        $table->boolean('exige_quitus')->default(false);
        $table->boolean('exige_cnps')->default(false);
        $table->boolean('exige_rccm')->default(false);
        $table->boolean('exige_faillite')->default(false);

        $table->string('prestataire_retenu')->nullable(); 
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};