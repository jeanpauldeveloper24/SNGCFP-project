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
        Schema::create('budgets', function (Blueprint $table) {
    $table->id();
    $table->string('libelle');
    $table->decimal('montant_alloue', 18, 2); 
    $table->decimal('montant_engage', 18, 2)->default(0); 
    $table->decimal('montant_paye', 18, 2)->default(0); 
    $table->foreignId('project_id')->constrained('projects'); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
