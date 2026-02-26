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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // 
            $table->string('name'); // [cite: 1, 2]
            $table->string('email')->unique(); // [cite: 1, 2]
            $table->timestamp('email_verified_at')->nullable(); // [cite: 2]
            $table->string('password'); // [cite: 1, 2]
            
            // Ajouts pour la conformité Firebase JSON 
            $table->string('phone')->nullable(); // 
            $table->string('photo')->nullable(); // 
            $table->string('work_at')->nullable(); // 
            $table->enum('status', ['actif', 'suspendu', 'inactif'])->default('actif'); // 
            $table->timestamp('last_connection')->nullable(); // 
            
            // Relations
            $table->foreignId('role_id')->nullable()->constrained('roles'); // 
            $table->foreignId('created_by')->nullable()->constrained('users'); // 
            
            $table->rememberToken(); // [cite: 2]
            $table->timestamps(); // 
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
