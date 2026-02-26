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
        Schema::create('audit_logs', function (Blueprint $table) {
    $table->id();
    $table->string('table_cible'); 
    $table->string('action'); 
    $table->json('ancienne_valeur')->nullable(); 
    $table->json('nouvelle_valeur')->nullable(); 
    $table->string('ip_address'); 
    $table->foreignId('user_id')->constrained('users'); 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
