<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Desenvolvimento Web',
                'description' => 'Cursos sobre desenvolvimento de websites e aplicações web',
                'icon' => 'fas fa-code',
                'color' => '#007bff',
                'sort_order' => 1,
            ],
            [
                'name' => 'Programação',
                'description' => 'Cursos de linguagens de programação e algoritmos',
                'icon' => 'fas fa-laptop-code',
                'color' => '#28a745',
                'sort_order' => 2,
            ],
            [
                'name' => 'Design',
                'description' => 'Cursos de design gráfico, UI/UX e design digital',
                'icon' => 'fas fa-paint-brush',
                'color' => '#dc3545',
                'sort_order' => 3,
            ],
            [
                'name' => 'Marketing Digital',
                'description' => 'Cursos sobre marketing online, SEO e redes sociais',
                'icon' => 'fas fa-bullhorn',
                'color' => '#ffc107',
                'sort_order' => 4,
            ],
            [
                'name' => 'Negócios',
                'description' => 'Cursos sobre empreendedorismo, gestão e finanças',
                'icon' => 'fas fa-briefcase',
                'color' => '#6f42c1',
                'sort_order' => 5,
            ],
            [
                'name' => 'Fotografia',
                'description' => 'Cursos de fotografia digital e edição de imagens',
                'icon' => 'fas fa-camera',
                'color' => '#fd7e14',
                'sort_order' => 6,
            ],
            [
                'name' => 'Música',
                'description' => 'Cursos de instrumentos musicais e produção musical',
                'icon' => 'fas fa-music',
                'color' => '#e83e8c',
                'sort_order' => 7,
            ],
            [
                'name' => 'Idiomas',
                'description' => 'Cursos de idiomas estrangeiros',
                'icon' => 'fas fa-globe',
                'color' => '#17a2b8',
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
