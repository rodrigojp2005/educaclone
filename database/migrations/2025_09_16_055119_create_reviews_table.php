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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('rating')->unsigned(); // 1-5 estrelas
            $table->text('comment')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamp('reviewed_at')->useCurrent();
            
            // Relacionamentos
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Índices
            $table->unique(['user_id', 'course_id']); // Um usuário só pode avaliar um curso uma vez
            $table->index(['course_id', 'is_approved']);
            $table->index(['course_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
