<?php
namespace App\Http\Controllers;

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
        Schema::create('markets', function (Blueprint $blueprint) {
            $blueprint->id();
            
            // Les clés étrangères indispensables (reliées à tes tables)
            $blueprint->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $blueprint->foreignId('project_module_id')->constrained('project_modules')->onDelete('cascade');
            
            // Informations générales du marché
            $blueprint->string('numero_reference')->unique();
            $blueprint->string('objet');
            $blueprint->decimal('montant', 15, 2); // Stocke proprement les sommes en FCFA
            $blueprint->string('devise')->default('XOF'); // FCFA par défaut
            
            // Stockage JSON de tes exigences (besoins_designation & besoins_quantite)
            $blueprint->json('besoins_materiels'); 
            
            // Suivi du cycle de vie et Workflow du DAO
            $blueprint->string('status')->default('En cours');
            $blueprint->string('etape')->default('EXPRESSION_BESOIN');
            
            // Critères booléens du Tri Administratif Initial
            $blueprint->boolean('exige_quitus')->default(false);
            $blueprint->boolean('exige_cnps')->default(false);
            $blueprint->boolean('exige_rccm')->default(false);
            $blueprint->boolean('exige_faillite')->default(false);
            
            // Gestion des dates clés
            $blueprint->dateTime('candidature_start_date')->nullable();
            $blueprint->dateTime('candidature_end_date')->nullable();
            $blueprint->date('date_lancement')->nullable();
            $blueprint->date('date_attribution')->nullable();
            
            // Attributions et auditabilité
            $blueprint->string('prestataire_retenu')->nullable();
            $blueprint->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            $blueprint->timestamps();
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