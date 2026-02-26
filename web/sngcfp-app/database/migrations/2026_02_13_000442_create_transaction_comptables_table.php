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
        Schema::create('transactions_comptables', function (Blueprint $table) {
    $table->id();
    $table->string('reference_piece'); 
    $table->string('libelle'); 
    $table->decimal('montant', 18, 2); 
    $table->date('date_operation'); 
    $table->string('compte_debit'); 
    $table->string('compte_credit'); 
    $table->foreignId('project_id')->constrained('projects'); 
    $table->foreignId('created_by')->constrained('users'); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_comptables');
    }
};
