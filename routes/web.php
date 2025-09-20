<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CourseController as PublicCourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonProgressController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MyCoursesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catálogo de cursos (público)
Route::get('/courses', [PublicCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [PublicCourseController::class, 'show'])->name('courses.show');

// Matrícula e progresso (autenticado)
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course:slug}/enroll', [EnrollmentController::class, 'store'])->name('courses.enroll');
    Route::post('/lessons/{lesson:slug}/toggle-progress', [LessonProgressController::class, 'toggle'])->name('lessons.toggleProgress');
    Route::post('/courses/{course:slug}/reviews', [ReviewController::class, 'store'])->name('courses.reviews.store');
    Route::get('/my-courses', [MyCoursesController::class, 'index'])->name('my-courses.index');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->isInstructor()) {
        return redirect()->route('instructor.dashboard');
    }
    if ($user->isStudent()) {
        return redirect()->route('my-courses.index');
    }
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas do painel do instrutor
Route::prefix('instructor')->name('instructor.')->middleware(['auth','role:instructor'])->group(function () {
    \App\Http\Controllers\Instructor\DashboardController::routes();
    Route::resource('courses', \App\Http\Controllers\Instructor\CourseController::class);
    // Lessons nested under courses
    Route::resource('courses.lessons', \App\Http\Controllers\Instructor\LessonController::class)->scoped([
        'course' => 'id',
        'lesson' => 'id',
    ])->shallow();
});

// Rotas do painel administrativo
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Debug temporário do layout do admin (remover em produção depois de validar)
    Route::get('/_debug', function () { return view('admin.debug'); })->name('debug');
    Route::resource('users', UserController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('categories', CategoryController::class);
});

require __DIR__.'/auth.php';
