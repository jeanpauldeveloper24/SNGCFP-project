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
        Schema::create('risks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->enum('level', ['CRITIQUE', 'MODERE', 'MINEUR']);
        $table->string('label');
        $table->boolean('is_archived')->default(false); // <--- VÉRIFIE CETTE LIGNE
        $table->foreignId('project_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risks');
    }
};
