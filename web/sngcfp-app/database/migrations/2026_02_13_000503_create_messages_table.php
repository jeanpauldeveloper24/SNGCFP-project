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
        Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->text('text'); 
    $table->string('media')->nullable(); 
    $table->foreignId('sender')->constrained('users'); 
    $table->foreignId('receiver')->constrained('users'); 
    $table->timestamp('send_at')->nullable(); 
    $table->timestamp('read_at')->nullable(); // Corrigé de 'learn_at' pour la clarté 
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
