<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o instrutor criado anteriormente
        $instructor = User::where('role', 'instructor')->first();
        
        if (!$instructor) {
            $this->command->error('Nenhum instrutor encontrado. Execute primeiro o AdminUserSeeder.');
            return;
        }

        // Buscar categorias
        $webDev = Category::where('slug', 'desenvolvimento-web')->first();
        $programming = Category::where('slug', 'programacao')->first();
        $design = Category::where('slug', 'design')->first();

        $courses = [
            [
                'title' => 'Laravel do Zero ao Avançado',
                'description' => 'Aprenda Laravel desde o básico até conceitos avançados. Este curso abrange desde a instalação até a criação de aplicações complexas com autenticação, APIs, testes e deploy.',
                'short_description' => 'Curso completo de Laravel para iniciantes e intermediários',
                'price' => 199.99,
                'discount_price' => 149.99,
                'level' => 'intermediate',
                'status' => 'published',
                'duration_minutes' => 1200, // 20 horas
                'requirements' => [
                    'Conhecimento básico de PHP',
                    'HTML e CSS básico',
                    'Noções de banco de dados'
                ],
                'what_you_learn' => [
                    'Criar aplicações web completas com Laravel',
                    'Implementar autenticação e autorização',
                    'Trabalhar com Eloquent ORM',
                    'Criar APIs RESTful',
                    'Realizar testes automatizados'
                ],
                'is_featured' => true,
                'instructor_id' => $instructor->id,
                'category_id' => $webDev ? $webDev->id : 1,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'JavaScript Moderno - ES6+',
                'description' => 'Domine o JavaScript moderno com ES6, ES7, ES8 e além. Aprenda sobre arrow functions, destructuring, async/await, modules e muito mais.',
                'short_description' => 'JavaScript moderno para desenvolvimento web',
                'price' => 149.99,
                'level' => 'beginner',
                'status' => 'published',
                'duration_minutes' => 800, // 13.3 horas
                'requirements' => [
                    'Conhecimento básico de HTML',
                    'Noções básicas de programação'
                ],
                'what_you_learn' => [
                    'Sintaxe moderna do JavaScript',
                    'Programação assíncrona',
                    'Manipulação do DOM',
                    'Módulos ES6',
                    'Debugging e ferramentas de desenvolvimento'
                ],
                'is_featured' => false,
                'instructor_id' => $instructor->id,
                'category_id' => $programming ? $programming->id : 2,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Design UI/UX com Figma',
                'description' => 'Aprenda a criar interfaces incríveis usando o Figma. Desde wireframes até protótipos interativos, este curso cobre todo o processo de design.',
                'short_description' => 'Design de interfaces modernas com Figma',
                'price' => 99.99,
                'discount_price' => 79.99,
                'level' => 'beginner',
                'status' => 'published',
                'duration_minutes' => 600, // 10 horas
                'requirements' => [
                    'Nenhum conhecimento prévio necessário',
                    'Computador com acesso à internet'
                ],
                'what_you_learn' => [
                    'Fundamentos do design UI/UX',
                    'Uso avançado do Figma',
                    'Criação de protótipos interativos',
                    'Design responsivo',
                    'Handoff para desenvolvedores'
                ],
                'is_featured' => true,
                'instructor_id' => $instructor->id,
                'category_id' => $design ? $design->id : 3,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Curso Gratuito de HTML e CSS',
                'description' => 'Introdução completa ao HTML e CSS. Perfeito para quem está começando no desenvolvimento web.',
                'short_description' => 'Fundamentos de HTML e CSS para iniciantes',
                'price' => 0,
                'level' => 'beginner',
                'status' => 'published',
                'duration_minutes' => 300, // 5 horas
                'requirements' => [
                    'Nenhum conhecimento prévio necessário'
                ],
                'what_you_learn' => [
                    'Estrutura básica do HTML',
                    'Estilização com CSS',
                    'Layout responsivo básico',
                    'Boas práticas de código'
                ],
                'is_featured' => false,
                'is_free' => true,
                'instructor_id' => $instructor->id,
                'category_id' => $webDev ? $webDev->id : 1,
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
