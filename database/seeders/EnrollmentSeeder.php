<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar estudantes (inclui os criados no ReviewSeeder e AdminUserSeeder)
        $students = User::where('role', 'student')->get();
        $courses = Course::published()->get();

        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('Sem estudantes ou cursos para matricular. Rode AdminUserSeeder, CourseSeeder antes.');
            return;
        }

        // Matricular cada estudante em 2-3 cursos aleatórios
        foreach ($students as $student) {
            $sample = $courses->shuffle()->take(min(3, $courses->count()));
            foreach ($sample as $course) {
                Enrollment::firstOrCreate(
                    [
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                    ],
                    [
                        'price_paid' => $course->is_free ? 0 : ($course->discount_price ?? $course->price ?? 0),
                        'status' => 'active',
                        'enrolled_at' => now()->subDays(rand(1, 15)),
                        'progress_percentage' => rand(0, 60),
                        'last_accessed_at' => now()->subDays(rand(0, 5)),
                    ]
                );
            }
        }

        // Garantir que exista ao menos 1 matrícula para o usuário principal se estiver logado
        $firstStudent = User::where('role', 'student')->first();
        $firstCourse = Course::published()->first();
        if ($firstStudent && $firstCourse) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $firstStudent->id,
                    'course_id' => $firstCourse->id,
                ],
                [
                    'price_paid' => $firstCourse->is_free ? 0 : ($firstCourse->discount_price ?? $firstCourse->price ?? 0),
                    'status' => 'active',
                    'enrolled_at' => now()->subDays(7),
                    'progress_percentage' => 30,
                    'last_accessed_at' => now()->subDays(1),
                ]
            );
        }
    }
}
