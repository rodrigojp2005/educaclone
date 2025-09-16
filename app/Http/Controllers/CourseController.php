<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Lista cursos publicados com filtros.
     */
    public function index(Request $request)
    {
        $query = Course::query()->with(['instructor', 'category'])
            ->withCount('enrollments')
            ->published();

        // Filtros
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('short_description', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        if ($category = $request->input('category')) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('slug', $category)->orWhere('id', $category);
            });
        }
        if ($level = $request->input('level')) {
            $query->where('level', $level);
        }
        if ($request->boolean('free')) {
            $query->where('is_free', true);
        }
        if ($sort = $request->input('sort')) {
            switch ($sort) {
                case 'popular':
                    $query->orderByDesc('enrollments_count');
                    break;
                case 'recent':
                    $query->orderByDesc('published_at');
                    break;
                case 'price_asc':
                    $query->orderBy('discount_price')->orderBy('price');
                    break;
                case 'price_desc':
                    $query->orderByDesc('discount_price')->orderByDesc('price');
                    break;
                default:
                    $query->orderByDesc('published_at');
            }
        } else {
            $query->orderByDesc('published_at');
        }

        $courses = $query->paginate(12)->appends($request->query());
        $categories = Category::orderBy('name')->get();

        return view('courses.index', compact('courses', 'categories'));
    }

    /**
     * Mostra os detalhes de um curso.
     */
    public function show(Course $course)
    {
        // Protege rascunhos
        if ($course->status !== 'published') {
            if (!Auth::check() || (!Auth::user()->isAdmin() && Auth::id() !== $course->instructor_id)) {
                abort(404);
            }
        }

        $course->load([
            'instructor', 'category',
            'lessons' => function ($q) { $q->ordered(); },
            'reviews.user' => function ($q) { $q->approved()->latest('reviewed_at'); }
        ]);

        $enrolled = false;
        if (Auth::check()) {
            $enrolled = $course->enrollments()->where('user_id', Auth::id())->exists();
        }

        return view('courses.show', compact('course', 'enrolled'));
    }
}
