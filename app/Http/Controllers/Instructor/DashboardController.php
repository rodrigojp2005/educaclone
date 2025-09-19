<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public static function routes(): void
    {
        \Illuminate\Support\Facades\Route::get('/', [self::class, 'index'])->name('dashboard');
    }

    public function index()
    {
        $instructorId = Auth::id();

        $stats = [
            'my_courses' => Course::where('instructor_id', $instructorId)->count(),
            'published_courses' => Course::where('instructor_id', $instructorId)->where('status','published')->count(),
            'total_students' => Enrollment::whereHas('course', fn($q)=>$q->where('instructor_id', $instructorId))->count(),
            'average_rating' => Review::whereHas('course', fn($q)=>$q->where('instructor_id', $instructorId))->avg('rating') ?? 0,
        ];

        $recentCourses = Course::where('instructor_id', $instructorId)
            ->withCount('enrollments')
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with(['user','course'])
            ->whereHas('course', fn($q)=>$q->where('instructor_id', $instructorId))
            ->latest('reviewed_at')
            ->take(5)
            ->get();

        return view('instructor.dashboard', compact('stats','recentCourses','recentReviews'));
    }
}
