<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar cursos criados anteriormente
        $laravelCourse = Course::where('slug', 'laravel-do-zero-ao-avancado')->first();
        $jsCourse = Course::where('slug', 'javascript-moderno-es6')->first();
        $figmaCourse = Course::where('slug', 'design-ui-ux-com-figma')->first();
        $htmlCourse = Course::where('slug', 'curso-gratuito-de-html-e-css')->first();

        if ($laravelCourse) {
            $laravelLessons = [
                [
                    'title' => 'Introdução ao Laravel',
                    'description' => 'Visão geral do framework Laravel e suas principais características',
                    'type' => 'video',
                    // Exemplo com Bunny Stream (substitua pelo GUID real no futuro)
                    'provider' => 'bunny',
                    'provider_video_id' => 'YOUR_BUNNY_VIDEO_GUID',
                    'provider_signed' => true,
                    'duration_minutes' => 15,
                    'sort_order' => 1,
                    'is_free' => true,
                    'is_published' => true,
                    'course_id' => $laravelCourse->id,
                ],
                [
                    'title' => 'Instalação e Configuração',
                    'description' => 'Como instalar e configurar o Laravel em seu ambiente de desenvolvimento',
                    'type' => 'video',
                    'provider' => 'bunny',
                    'provider_video_id' => 'YOUR_BUNNY_VIDEO_GUID_2',
                    'provider_signed' => true,
                    'duration_minutes' => 20,
                    'sort_order' => 2,
                    'is_published' => true,
                    'course_id' => $laravelCourse->id,
                ],
                [
                    'title' => 'Rotas e Controllers',
                    'description' => 'Entendendo o sistema de rotas e controllers do Laravel',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 25,
                    'sort_order' => 3,
                    'is_published' => true,
                    'course_id' => $laravelCourse->id,
                ],
                [
                    'title' => 'Eloquent ORM',
                    'description' => 'Trabalhando com o Eloquent ORM para manipulação de dados',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 30,
                    'sort_order' => 4,
                    'is_published' => true,
                    'course_id' => $laravelCourse->id,
                ],
                [
                    'title' => 'Exercício Prático',
                    'description' => 'Teste seus conhecimentos sobre Laravel',
                    'type' => 'quiz',
                    'quiz_data' => [
                        'questions' => [
                            [
                                'question' => 'Qual comando cria um novo projeto Laravel?',
                                'options' => [
                                    'composer create-project laravel/laravel',
                                    'laravel new project',
                                    'php artisan new',
                                    'npm create laravel'
                                ],
                                'correct' => 0
                            ]
                        ]
                    ],
                    'duration_minutes' => 10,
                    'sort_order' => 5,
                    'is_published' => true,
                    'course_id' => $laravelCourse->id,
                ],
            ];

            foreach ($laravelLessons as $lesson) {
                $slug = Str::slug($lesson['title']);
                Lesson::updateOrCreate(
                    ['course_id' => $laravelCourse->id, 'slug' => $slug],
                    array_merge($lesson, ['slug' => $slug])
                );
            }
        }

        if ($jsCourse) {
            $jsLessons = [
                [
                    'title' => 'Introdução ao ES6+',
                    'description' => 'Novidades do JavaScript moderno',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 12,
                    'sort_order' => 1,
                    'is_free' => true,
                    'is_published' => true,
                    'course_id' => $jsCourse->id,
                ],
                [
                    'title' => 'Arrow Functions',
                    'description' => 'Entendendo e usando arrow functions',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 18,
                    'sort_order' => 2,
                    'is_published' => true,
                    'course_id' => $jsCourse->id,
                ],
                [
                    'title' => 'Destructuring',
                    'description' => 'Desestruturação de objetos e arrays',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 22,
                    'sort_order' => 3,
                    'is_published' => true,
                    'course_id' => $jsCourse->id,
                ],
            ];

            foreach ($jsLessons as $lesson) {
                $slug = Str::slug($lesson['title']);
                Lesson::updateOrCreate(
                    ['course_id' => $jsCourse->id, 'slug' => $slug],
                    array_merge($lesson, ['slug' => $slug])
                );
            }
        }

        if ($htmlCourse) {
            $htmlLessons = [
                [
                    'title' => 'Estrutura Básica do HTML',
                    'description' => 'Aprendendo a estrutura básica de um documento HTML',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 15,
                    'sort_order' => 1,
                    'is_free' => true,
                    'is_published' => true,
                    'course_id' => $htmlCourse->id,
                ],
                [
                    'title' => 'Tags HTML Essenciais',
                    'description' => 'Conhecendo as principais tags HTML',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 20,
                    'sort_order' => 2,
                    'is_free' => true,
                    'is_published' => true,
                    'course_id' => $htmlCourse->id,
                ],
                [
                    'title' => 'Introdução ao CSS',
                    'description' => 'Primeiros passos com CSS',
                    'type' => 'video',
                    'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                    'duration_minutes' => 25,
                    'sort_order' => 3,
                    'is_free' => true,
                    'is_published' => true,
                    'course_id' => $htmlCourse->id,
                ],
            ];

            foreach ($htmlLessons as $lesson) {
                $slug = Str::slug($lesson['title']);
                Lesson::updateOrCreate(
                    ['course_id' => $htmlCourse->id, 'slug' => $slug],
                    array_merge($lesson, ['slug' => $slug])
                );
            }
        }
    }
}
