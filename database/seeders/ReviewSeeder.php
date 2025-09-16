<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Course;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o estudante criado anteriormente
        $student = User::where('role', 'student')->first();
        
        if (!$student) {
            $this->command->error('Nenhum estudante encontrado. Execute primeiro o AdminUserSeeder.');
            return;
        }

        // Buscar cursos
        $courses = Course::published()->take(3)->get();

        if ($courses->isEmpty()) {
            $this->command->error('Nenhum curso encontrado. Execute primeiro o CourseSeeder.');
            return;
        }

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'Excelente curso! Muito bem explicado e com exemplos práticos. Recomendo para todos que querem aprender Laravel.',
                'user_id' => $student->id,
                'course_id' => $courses->first()->id,
                'reviewed_at' => now()->subDays(5),
            ],
            [
                'rating' => 4,
                'comment' => 'Bom curso, mas poderia ter mais exercícios práticos. No geral, muito útil para iniciantes.',
                'user_id' => $student->id,
                'course_id' => $courses->skip(1)->first()->id,
                'reviewed_at' => now()->subDays(3),
            ],
            [
                'rating' => 5,
                'comment' => 'Perfeito para quem está começando! Linguagem clara e didática.',
                'user_id' => $student->id,
                'course_id' => $courses->skip(2)->first()->id,
                'reviewed_at' => now()->subDays(1),
            ],
        ];

        // Criar mais alguns usuários para diversificar as avaliações
        $additionalUsers = [];
        for ($i = 1; $i <= 3; $i++) {
            $additionalUsers[] = User::create([
                'name' => "Estudante $i",
                'email' => "estudante$i@example.com",
                'password' => bcrypt('password'),
                'role' => 'student',
                'email_verified_at' => now(),
            ]);
        }

        // Adicionar mais avaliações com diferentes usuários
        $additionalReviews = [
            [
                'rating' => 4,
                'comment' => 'Muito bom! Aprendi bastante sobre desenvolvimento web.',
                'user_id' => $additionalUsers[0]->id,
                'course_id' => $courses->first()->id,
                'reviewed_at' => now()->subDays(4),
            ],
            [
                'rating' => 5,
                'comment' => 'Curso fantástico! O instrutor explica muito bem.',
                'user_id' => $additionalUsers[1]->id,
                'course_id' => $courses->first()->id,
                'reviewed_at' => now()->subDays(2),
            ],
            [
                'rating' => 3,
                'comment' => 'Curso ok, mas esperava mais conteúdo avançado.',
                'user_id' => $additionalUsers[2]->id,
                'course_id' => $courses->skip(1)->first()->id,
                'reviewed_at' => now()->subHours(12),
            ],
        ];

        // Criar todas as avaliações
        foreach (array_merge($reviews, $additionalReviews) as $review) {
            Review::create($review);
        }
    }
}
