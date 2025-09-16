<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Não permitir matrícula em draft/archived
        if ($course->status !== 'published') {
            abort(403, 'Curso não disponível para matrícula.');
        }

        $already = Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ($already) {
            return back()->with('success', 'Você já está matriculado neste curso.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'price_paid' => $course->is_free ? 0 : ($course->discount_price ?? $course->price),
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Matrícula realizada com sucesso!');
    }
}
