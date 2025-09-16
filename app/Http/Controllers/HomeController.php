<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        // Cursos em destaque
        $featuredCourses = Course::published()
            ->where('is_featured', true)
            ->with(['instructor', 'category', 'reviews'])
            ->take(6)
            ->get();

        // Cursos mais populares (por número de matrículas)
        $popularCourses = Course::published()
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->with(['instructor', 'category', 'reviews'])
            ->take(8)
            ->get();

        // Cursos gratuitos
        $freeCourses = Course::published()
            ->where('is_free', true)
            ->with(['instructor', 'category', 'reviews'])
            ->take(4)
            ->get();

        // Categorias principais
        $categories = Category::orderBy('sort_order')
            ->take(8)
            ->get();

        // Estatísticas gerais
        $stats = [
            'total_courses' => Course::published()->count(),
            'total_students' => \App\Models\User::where('role', 'student')->count(),
            'total_instructors' => \App\Models\User::where('role', 'instructor')->count(),
            'average_rating' => Review::avg('rating') ?? 0,
        ];

        return view('home', compact(
            'featuredCourses',
            'popularCourses',
            'freeCourses',
            'categories',
            'stats'
        ));
    }
}
