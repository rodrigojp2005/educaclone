<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class MyCoursesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $enrollments = Enrollment::with(['course.category','course.instructor'])
            ->where('user_id', $user->id)
            ->orderByDesc('enrolled_at')
            ->get();

        return view('courses.my-courses', compact('enrollments'));
    }
}
