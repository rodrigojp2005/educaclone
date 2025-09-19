<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    protected function ensureOwnership(Course $course): void
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
    }

    public function index(Course $course)
    {
        $this->ensureOwnership($course);
        $lessons = $course->lessons()->ordered()->paginate(20);
        return view('instructor.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        $this->ensureOwnership($course);
        return view('instructor.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->ensureOwnership($course);

        $data = $this->validateLesson($request);
        $this->normalizeProviderFields($data);
        $data['course_id'] = $course->id;

        Lesson::create($data);

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Aula criada com sucesso.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        $this->ensureOwnership($course);
        if ($lesson->course_id !== $course->id) abort(404);
        return view('instructor.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $this->ensureOwnership($course);
        if ($lesson->course_id !== $course->id) abort(404);

        $data = $this->validateLesson($request, $lesson->id);
        $this->normalizeProviderFields($data);

        $lesson->update($data);

        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Aula atualizada com sucesso.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $this->ensureOwnership($course);
        if ($lesson->course_id !== $course->id) abort(404);
        $lesson->delete();
        return redirect()->route('instructor.courses.lessons.index', $course)
            ->with('success', 'Aula excluída.');
    }

    protected function validateLesson(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|in:video,text,quiz,file',
            'provider' => 'nullable|string|in:youtube,cloudflare,bunny,url',
            'video_input' => 'nullable|string|max:500', // YouTube URL/ID or provider UID
            'video_url' => 'nullable|url|max:1000',
            'content' => 'nullable|string',
            'duration_minutes' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_free' => 'sometimes|boolean',
            'is_published' => 'sometimes|boolean',
        ]);
    }

    protected function normalizeProviderFields(array &$data): void
    {
        $data['is_free'] = (bool)($data['is_free'] ?? false);
        $data['is_published'] = (bool)($data['is_published'] ?? false);

        // Reset provider-specific fields
        $data['provider_video_id'] = null;
        $data['provider_signed'] = false;
        $data['is_external'] = false;

        if (($data['type'] ?? null) !== 'video') {
            // For non-video lessons, clear provider/video fields
            $data['provider'] = null;
            $data['video_url'] = null;
            return;
        }

        $provider = $data['provider'] ?? null;
        $input = trim((string)($data['video_input'] ?? ''));

        if ($provider === 'youtube' && $input) {
            $videoId = $this->extractYouTubeId($input);
            if ($videoId) {
                $data['provider_video_id'] = $videoId;
                $data['is_external'] = true;
            }
        } elseif (in_array($provider, ['cloudflare', 'bunny']) && $input) {
            // Expecting a direct video UID/GUID copied from the provider dashboard
            $data['provider_video_id'] = $input;
            $data['is_external'] = true;
        } elseif ($provider === 'url' && !empty($data['video_url'])) {
            // Direct URL fallback
            $data['is_external'] = true;
        }

        unset($data['video_input']);
    }

    protected function extractYouTubeId(string $value): ?string
    {
        // Accept raw IDs or common URL formats
        if (preg_match('~^[a-zA-Z0-9_-]{11}$~', $value)) {
            return $value;
        }
        if (preg_match('~(?:v=|youtu\.be/|embed/)([a-zA-Z0-9_-]{11})~', $value, $m)) {
            return $m[1];
        }
        return null;
    }
}
