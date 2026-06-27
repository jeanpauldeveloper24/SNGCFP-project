<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('user_role')->nullable();
            $table->string('action_type'); // CREATE, UPDATE, DELETE, READ
            $table->text('description');   // Ex: "A mis à jour le marché N°23"
            $table->string('ip_address')->nullable();
            $table->timestamps(); // Génère automatiquement created_at (Horodatage)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};