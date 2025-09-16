<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Review;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Verifica matrícula
        $enrolled = Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists();
        if (!$enrolled) {
            return back()->with('error', 'Você precisa estar matriculado para avaliar.');
        }

        // Verifica se já avaliou
        if (Review::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Você já avaliou este curso.');
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'] ?? null,
            'is_approved' => true,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Avaliação enviada!');
    }
}
