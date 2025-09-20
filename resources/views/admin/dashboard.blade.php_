@extends('admin.base')
@section('title', 'Dashboard Admin')
@section('content')
<!-- ADMIN-DASHBOARD-STYLE-FALLBACK: estilos mínimos para quando o layout não carrega -->
<style>
    .card { border: 1px solid #e0e0e0; border-radius: 0.5rem; background: #fff; margin-bottom: 1rem; }
    .card-header { padding: 0.75rem 1rem; border-bottom: 1px solid #e9ecef; background: #f8f9fa; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
    .card-body { padding: 1rem; }
    .shadow { box-shadow: 0 0.5rem 1rem rgba(0,0,0,.10); }
    .badge { display: inline-block; padding: .35em .6em; font-size: .75rem; font-weight: 600; border-radius: .25rem; }
    .bg-primary { background-color: #0d6efd !important; color: #fff; }
    .bg-success { background-color: #198754 !important; color: #fff; }
    .bg-info { background-color: #0dcaf0 !important; color: #fff; }
    .bg-warning { background-color: #ffc107 !important; color: #212529; }
    .bg-danger { background-color: #dc3545 !important; color: #fff; }
    .text-muted { color: #6c757d !important; }
    .border-left-primary { border-left: .25rem solid #0d6efd !important; }
    .border-left-success { border-left: .25rem solid #198754 !important; }
    .border-left-info { border-left: .25rem solid #0dcaf0 !important; }
    .border-left-warning { border-left: .25rem solid #ffc107 !important; }
    .h-100 { height: 100%; }
    .py-2 { padding-top: .5rem; padding-bottom: .5rem; }
    .mb-4 { margin-bottom: 1.5rem; }
    .mb-3 { margin-bottom: 1rem; }
    .me-2 { margin-right: .5rem; }
    .m-0 { margin: 0; }
    .row { display: flex; flex-wrap: wrap; margin-right: -0.5rem; margin-left: -0.5rem; }
    .col, .col-auto, [class^="col-"] { position: relative; width: 100%; padding-right: .5rem; padding-left: .5rem; }
    .col-auto { flex: 0 0 auto; width: auto; }
    .col-md-6 { flex: 0 0 auto; width: 50%; }
    .col-lg-6 { flex: 0 0 auto; width: 50%; }
    .col-lg-12 { flex: 0 0 auto; width: 100%; }
    .col-xl-3 { flex: 0 0 auto; width: 25%; }
    .text-primary { color: #0d6efd !important; }
    .text-success { color: #198754 !important; }
    .text-info { color: #0dcaf0 !important; }
    .text-warning { color: #ffc107 !important; }
    .text-gray-800 { color: #343a40 !important; }
    .text-uppercase { text-transform: uppercase; }
    .font-weight-bold { font-weight: 700; }
    .small { font-size: .875rem; }
    .h5 { font-size: 1.25rem; }
    .h6 { font-size: 1rem; }
    .fa-2x { font-size: 2em; }
    .align-items-center { align-items: center; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    hr { border: 0; border-top: 1px solid #e9ecef; margin: .75rem 0; }
    @media (max-width: 992px) {
        .col-lg-6 { width: 100%; }
        .col-xl-3, .col-md-6 { width: 100%; }
    }
    @media (max-width: 576px) {
        .h5 { font-size: 1.1rem; }
        .h6 { font-size: .95rem; }
    }
    /* Fim do fallback */
</style>
<div class="row">
    <!-- Estatísticas -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Usuários
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_users']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Cursos Publicados
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['published_courses']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total de Matrículas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_enrollments']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Receita Total
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Cursos Mais Populares -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Cursos Mais Populares</h6>
            </div>
            <div class="card-body">
                @if($popularCourses->count() > 0)
                    @foreach($popularCourses as $course)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $course->title }}</h6>
                                <small class="text-muted">{{ $course->enrollments_count }} matrículas</small>
                            </div>
                            <span class="badge bg-primary">{{ $course->status }}</span>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p class="text-muted">Nenhum curso encontrado.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Usuários Recentes -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Usuários Recentes</h6>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                    @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'instructor' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p class="text-muted">Nenhum usuário encontrado.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Avaliações Recentes -->
    <div class="col-lg-12 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Avaliações Recentes</h6>
            </div>
            <div class="card-body">
                @if($recentReviews->count() > 0)
                    @foreach($recentReviews as $review)
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <h6 class="mb-0 me-2">{{ $review->user->name }}</h6>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-1">{{ Str::limit($review->comment, 100) }}</p>
                                <small class="text-muted">
                                    Curso: {{ $review->course->title }} • 
                                    {{ $review->reviewed_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @else
                    <p class="text-muted">Nenhuma avaliação encontrada.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estatísticas Adicionais -->
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">Estudantes</div>
                        <div class="text-lg font-weight-bold">{{ number_format($stats['total_students']) }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-graduate fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">Instrutores</div>
                        <div class="text-lg font-weight-bold">{{ number_format($stats['total_instructors']) }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">Avaliação Média</div>
                        <div class="text-lg font-weight-bold">{{ number_format($stats['average_rating'], 1) }}/5</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

