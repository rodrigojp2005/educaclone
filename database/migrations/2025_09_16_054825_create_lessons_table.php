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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->enum('type', ['video', 'text', 'quiz', 'file'])->default('video');
            $table->string('video_url')->nullable(); // URL do vídeo
            $table->string('video_file')->nullable(); // Arquivo de vídeo local
            $table->text('content')->nullable(); // Conteúdo textual
            $table->string('file_path')->nullable(); // Arquivo para download
            $table->integer('duration_minutes')->default(0); // Duração em minutos
            $table->integer('sort_order')->default(0); // Ordem da aula no curso
            $table->boolean('is_free')->default(false); // Aula gratuita (preview)
            $table->boolean('is_published')->default(false);
            $table->json('quiz_data')->nullable(); // Dados do quiz (se aplicável)
            
            // Relacionamentos
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            
            $table->timestamps();
            
            // Índices
            $table->index(['course_id', 'sort_order']);
            $table->index(['course_id', 'is_published']);
            $table->unique(['course_id', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
