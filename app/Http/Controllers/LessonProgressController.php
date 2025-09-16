<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LessonProgressController extends Controller
{
    public function toggle(Request $request, Lesson $lesson)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Verifica matrícula
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $lesson->course_id)
            ->first();
        if (!$enrollment) {
            return response()->json(['message' => 'Você não está matriculado neste curso.'], 403);
        }

        $progress = LessonProgress::firstOrCreate([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);

        // Toggle
        if ($progress->is_completed) {
            $progress->update([
                'is_completed' => false,
                'completed_at' => null,
            ]);
        } else {
            $progress->markAsCompleted();
        }

        // Recalcula progresso do curso
        $enrollment->updateProgress();

        return response()->json([
            'completed' => $progress->is_completed,
            'progress_percentage' => $enrollment->progress_percentage,
        ]);
    }
}
