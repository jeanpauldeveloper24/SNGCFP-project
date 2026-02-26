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
        Schema::create('paiements', function (Blueprint $table) {
    $table->id();
    $table->string('reference'); 
    $table->decimal('montant', 18, 2); 
    $table->date('date_paiement'); 
    $table->string('beneficiaire'); 
    $table->enum('type', ['DRF', 'DPD']); 
    $table->enum('status', ['soumis', 'valide', 'rejete']); 
    $table->foreignId('project_id')->constrained('projects'); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
