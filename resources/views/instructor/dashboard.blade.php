@extends('instructor.layout')

@section('instructor-page-title','Painel do Instrutor')

@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Meus Cursos</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['my_courses']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Cursos Publicados</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['published_courses']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Estudantes</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_students']) }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Avaliação Média</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['average_rating'],1) }}/5</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Meus Cursos Recentes</h6>
            </div>
            <div class="card-body">
                @forelse($recentCourses as $course)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <strong>{{ $course->title }}</strong>
                            <div class="text-muted small">{{ $course->enrollments_count }} matrículas</div>
                        </div>
                        <span class="badge bg-{{ $course->status==='published'?'success':($course->status==='draft'?'secondary':'dark') }}">{{ ucfirst($course->status) }}</span>
                    </div>
                    @if(!$loop->last)<hr>@endif
                @empty
                    <p class="text-muted">Nenhum curso.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Avaliações Recentes</h6>
            </div>
            <div class="card-body">
                @forelse($recentReviews as $review)
                    <div class="mb-2">
                        <strong>{{ $review->user->name }}</strong> — 
                        <span class="text-warning">
                            @for($i=1;$i<=5;$i++)
                                <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </span>
                        <div class="small text-muted">{{ $review->course->title }} • {{ $review->reviewed_at?->diffForHumans() }}</div>
                        <div>{{ $review->comment }}</div>
                    </div>
                    @if(!$loop->last)<hr>@endif
                @empty
                    <p class="text-muted">Sem avaliações.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
