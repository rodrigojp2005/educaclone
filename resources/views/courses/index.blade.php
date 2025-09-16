@extends('layout')

@section('title', 'Cursos')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 fw-bold">Catálogo de Cursos</h1>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">Todas Categorias</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('category') == $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="level" class="form-select">
                <option value="">Todos Níveis</option>
                <option value="beginner" @selected(request('level')=='beginner')>Iniciante</option>
                <option value="intermediate" @selected(request('level')=='intermediate')>Intermediário</option>
                <option value="advanced" @selected(request('level')=='advanced')>Avançado</option>
            </select>
        </div>
        <div class="col-md-1 form-check d-flex align-items-center">
            <input class="form-check-input me-2" type="checkbox" value="1" name="free" id="freeCheck" @checked(request('free'))>
            <label class="form-check-label" for="freeCheck">Grátis</label>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-select">
                <option value="">Ordenar</option>
                <option value="popular" @selected(request('sort')=='popular')>Popular</option>
                <option value="recent" @selected(request('sort')=='recent')>Recentes</option>
                <option value="price_asc" @selected(request('sort')=='price_asc')>Preço ↑</option>
                <option value="price_desc" @selected(request('sort')=='price_desc')>Preço ↓</option>
            </select>
        </div>
        <div class="col-12">
            <button class="btn btn-primary">Filtrar</button>
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
        </div>
    </form>

    @if($courses->count())
        <div class="row">
            @foreach($courses as $course)
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="card h-100 course-card">
                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/400x200?text=' . urlencode($course->title) }}" class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary mb-2">{{ $course->category->name ?? 'Categoria' }}</span>
                            <h6 class="fw-bold mb-1">{{ Str::limit($course->title, 55) }}</h6>
                            <small class="text-muted mb-2">{{ $course->instructor->name }}</small>
                            <div class="mb-2">
                                @php $rating = $course->average_rating; @endphp
                                <span class="text-warning">
                                    @for($i=1;$i<=5;$i++)
                                        @if($i <= $rating) ★ @else ☆ @endif
                                    @endfor
                                </span>
                                <small class="text-muted">{{ number_format($rating,1) }}</small>
                            </div>
                            <div class="mt-auto">
                                @if($course->is_free)
                                    <span class="text-success fw-bold">Gratuito</span>
                                @else
                                    @if($course->discount_price)
                                        <span class="text-primary fw-bold">R$ {{ number_format($course->discount_price,2,',','.') }}</span>
                                        <span class="price-original">R$ {{ number_format($course->price,2,',','.') }}</span>
                                    @else
                                        <span class="fw-bold">R$ {{ number_format($course->price,2,',','.') }}</span>
                                    @endif
                                @endif
                            </div>
                            <a href="{{ route('courses.show', $course->slug) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $courses->links() }}
        </div>
    @else
        <div class="alert alert-info">Nenhum curso encontrado.</div>
    @endif
</div>
@endsection
