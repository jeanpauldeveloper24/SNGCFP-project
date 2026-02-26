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
        Schema::create('indicateurs_agreges_firebase', function (Blueprint $table) {
    $table->id();
    $table->integer('project_id'); 
    $table->decimal('budget_total', 18, 2); 
    $table->decimal('budget_engage', 18, 2); 
    $table->decimal('budget_paye', 18, 2); 
    $table->integer('nombre_marches'); 
    $table->float('taux_execution'); 
    $table->integer('risques_detectes'); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicateur_agrege_firebases');
    }
};
