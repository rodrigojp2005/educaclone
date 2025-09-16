@extends('layout')

@section('title','Meus Cursos')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Meus Cursos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($enrollments->count())
        <div class="row">
            @foreach($enrollments as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 course-card">
                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/400x200?text=' . urlencode($course->title) }}" class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">{{ $course->category->name ?? 'Categoria' }}</span>
                                <span class="badge bg-secondary">{{ ucfirst($course->level) }}</span>
                            </div>
                            <h5 class="card-title">{{ Str::limit($course->title, 60) }}</h5>
                            <small class="text-muted mb-2">Instrutor: {{ $course->instructor->name }}</small>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%;" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">Progresso: {{ $enrollment->progress_percentage }}%</small>
                                <a href="{{ route('courses.show', $course->slug) }}#curriculum" class="btn btn-sm btn-outline-primary">Continuar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Você ainda não está matriculado em nenhum curso. <a href="{{ route('courses.index') }}">Explorar cursos</a></div>
    @endif
</div>
@endsection
@extends('layout')

@section('title','Meus Cursos')

@section('content')
<div class="container py-5">
    <h1 class="fw-bold mb-4">Meus Cursos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($enrollments->count())
        <div class="row">
            @foreach($enrollments as $enrollment)
                @php $course = $enrollment->course; @endphp
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/400x200?text=' . urlencode($course->title) }}" class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-primary">{{ $course->category->name ?? 'Categoria' }}</span>
                                <span class="badge bg-secondary">{{ ucfirst($course->level) }}</span>
                            </div>
                            <h5 class="card-title">{{ Str::limit($course->title, 60) }}</h5>
                            <small class="text-muted mb-2">Instrutor: {{ $course->instructor->name }}</small>
                            <div class="progress mb-3" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $enrollment->progress_percentage }}%;" aria-valuenow="{{ $enrollment->progress_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <small class="text-muted">Progresso: {{ $enrollment->progress_percentage }}%</small>
                                <a href="{{ route('courses.show', $course->slug) }}#curriculum" class="btn btn-sm btn-outline-primary">Continuar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Você ainda não está matriculado em nenhum curso. <a href="{{ route('courses.index') }}">Explorar cursos</a></div>
    @endif
</div>
@endsection
