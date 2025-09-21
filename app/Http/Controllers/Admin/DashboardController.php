<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        // Estatísticas gerais
        $stats = [
            'total_users' => User::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_instructors' => User::where('role', 'instructor')->count(),
            'total_courses' => Course::count(),
            'published_courses' => Course::where('status', 'published')->count(),
            'total_categories' => Category::count(),
            'total_enrollments' => Enrollment::count(),
            'total_reviews' => Review::count(),
            'average_rating' => Review::avg('rating') ?? 0,
        ];

        // Cursos mais populares (por número de matrículas)
        $popularCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(5)
            ->get();

        // Usuários registrados recentemente
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // Avaliações recentes
        $recentReviews = Review::with(['user', 'course'])
            ->latest('reviewed_at')
            ->take(5)
            ->get();

        // Receita total (simulada)
        $totalRevenue = Enrollment::sum('price_paid');

        return view('admin.dashboard2', compact(
            'stats',
            'popularCourses',
            'recentUsers',
            'recentReviews',
            'totalRevenue'
        ));
    }
}
