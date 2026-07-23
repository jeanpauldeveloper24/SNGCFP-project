<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_modules', function (Blueprint $table) {
            $table->id();
            
            // Relation avec le projet parent
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            
            // Optionnel : si le module est lié à un marché public
            $table->foreignId('market_id')->nullable()->constrained('markets')->nullOnDelete();

            $table->integer('number');
            $table->text('description')->nullable();
            
            // Unification sur besoin_financier et devise
            $table->double('besoin_financier', 15, 2);
            $table->string('devise')->nullable(); // Ex: 'XOF', 'USD'
            
            $table->string('duree')->nullable();
            $table->string('status')->default('Non débuté');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_modules');
    }
};