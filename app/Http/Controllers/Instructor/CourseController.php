<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->with(['category'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $categories = Category::orderBy('name')->get();

        return view('instructor.courses.index', compact('courses','categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'short_description' => ['nullable','string','max:500'],
            'description' => ['nullable','string'],
            'price' => ['nullable','numeric','min:0'],
            'discount_price' => ['nullable','numeric','min:0','lt:price'],
            'level' => ['nullable', Rule::in(['beginner','intermediate','advanced'])],
            'status' => ['required', Rule::in(['draft','published','archived'])],
            'language' => ['nullable','string','max:10'],
            'is_featured' => ['nullable','boolean'],
            'is_free' => ['nullable','boolean'],
            'published_at' => ['nullable','date'],
            'category_id' => ['required','exists:categories,id'],
        ]);

        $course = Course::create([
            'title' => $data['title'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? 0,
            'discount_price' => $data['discount_price'] ?? null,
            'level' => $data['level'] ?? 'beginner',
            'status' => $data['status'],
            'language' => $data['language'] ?? 'pt',
            'is_featured' => $data['is_featured'] ?? false,
            'is_free' => $data['is_free'] ?? false,
            'published_at' => $data['published_at'] ?? null,
            'instructor_id' => Auth::id(),
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('instructor.courses.edit', $course)->with('success', 'Curso criado com sucesso.');
    }

    public function edit(string $id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('instructor.courses.edit', compact('course','categories'));
    }

    public function update(Request $request, string $id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);

        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'short_description' => ['nullable','string','max:500'],
            'description' => ['nullable','string'],
            'price' => ['nullable','numeric','min:0'],
            'discount_price' => ['nullable','numeric','min:0','lt:price'],
            'level' => ['nullable', Rule::in(['beginner','intermediate','advanced'])],
            'status' => ['required', Rule::in(['draft','published','archived'])],
            'language' => ['nullable','string','max:10'],
            'is_featured' => ['nullable','boolean'],
            'is_free' => ['nullable','boolean'],
            'published_at' => ['nullable','date'],
            'category_id' => ['required','exists:categories,id'],
        ]);

        $course->update([
            'title' => $data['title'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? 0,
            'discount_price' => $data['discount_price'] ?? null,
            'level' => $data['level'] ?? 'beginner',
            'status' => $data['status'],
            'language' => $data['language'] ?? 'pt',
            'is_featured' => $data['is_featured'] ?? false,
            'is_free' => $data['is_free'] ?? false,
            'published_at' => $data['published_at'] ?? null,
            'category_id' => $data['category_id'],
        ]);

        return redirect()->route('instructor.courses.edit', $course)->with('success', 'Curso atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $course = Course::where('instructor_id', Auth::id())->findOrFail($id);
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Curso excluído com sucesso.');
    }
}
