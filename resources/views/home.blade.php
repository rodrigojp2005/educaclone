@extends('layout')

@section('title', 'Aprenda Online com os Melhores Cursos')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Aprenda Novas Habilidades Online
                </h1>
                <p class="lead mb-4">
                    Descubra milhares de cursos online com os melhores instrutores. 
                    Desenvolva suas habilidades e transforme sua carreira.
                </p>
                <div class="d-flex gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-play me-2"></i>
                            Começar Agora
                        </a>
                    @else
                        <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-play me-2"></i>
                            Continuar Aprendendo
                        </a>
                    @endguest
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">
                        Ver Cursos
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="hero-image">
                    <i class="fas fa-graduation-cap" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['total_courses']) }}</div>
                    <h5>Cursos Disponíveis</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['total_students']) }}</div>
                    <h5>Estudantes</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['total_instructors']) }}</div>
                    <h5>Instrutores</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($stats['average_rating'], 1) }}</div>
                    <h5>Avaliação Média</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Explore por Categoria</h2>
            <p class="text-muted">Encontre o curso perfeito para suas necessidades</p>
        </div>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="category-card h-100">
                        <div class="category-icon" style="color: {{ $category->color }}">
                            <i class="{{ $category->icon }}"></i>
                        </div>
                        <h5 class="fw-bold">{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->description }}</p>
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            Ver Cursos
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
@if($featuredCourses->count() > 0)
<section class="py-5 bg-light" id="courses">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cursos em Destaque</h2>
            <p class="text-muted">Os cursos mais recomendados pelos nossos instrutores</p>
        </div>
        <div class="row">
            @foreach($featuredCourses as $course)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card course-card h-100">
                        <img src="https://via.placeholder.com/400x200/{{ str_replace('#', '', $course->category->color ?? '007bff') }}/ffffff?text={{ urlencode($course->title) }}" 
                             class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $course->category->name }}</span>
                                <span class="badge bg-secondary">{{ ucfirst($course->level) }}</span>
                            </div>
                            <h5 class="card-title">{{ $course->title }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($course->short_description, 100) }}</p>
                            <div class="mb-2">
                                <small class="text-muted">Por {{ $course->instructor->name }}</small>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rating-stars me-2">
                                    @php
                                        $avgRating = $course->reviews->avg('rating') ?? 0;
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avgRating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">
                                    {{ number_format($avgRating, 1) }} ({{ $course->reviews->count() }} avaliações)
                                </small>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="price-tag">
                                        @if($course->is_free)
                                            <span class="text-success fw-bold">Gratuito</span>
                                        @else
                                            @if($course->discount_price)
                                                <span class="text-primary">R$ {{ number_format($course->discount_price, 2, ',', '.') }}</span>
                                                <span class="price-original ms-1">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                            @else
                                                <span class="text-primary">R$ {{ number_format($course->price, 2, ',', '.') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-primary btn-sm">Ver Curso</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-primary btn-lg">Ver Todos os Cursos</a>
        </div>
    </div>
</section>
@endif

<!-- Popular Courses Section -->
@if($popularCourses->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cursos Mais Populares</h2>
            <p class="text-muted">Os cursos com mais estudantes matriculados</p>
        </div>
        <div class="row">
            @foreach($popularCourses->take(4) as $course)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card course-card h-100">
                        <img src="https://via.placeholder.com/300x150/{{ str_replace('#', '', $course->category->color ?? '28a745') }}/ffffff?text={{ urlencode(Str::limit($course->title, 20)) }}" 
                             class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ Str::limit($course->title, 50) }}</h6>
                            <small class="text-muted mb-2">{{ $course->instructor->name }}</small>
                            <div class="d-flex align-items-center mb-2">
                                <div class="rating-stars me-2">
                                    @php
                                        $avgRating = $course->reviews->avg('rating') ?? 0;
                                    @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $avgRating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-muted">{{ number_format($avgRating, 1) }}</small>
                            </div>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $course->enrollments_count }} estudantes</small>
                                    @if($course->is_free)
                                        <span class="text-success fw-bold">Gratuito</span>
                                    @else
                                        <span class="fw-bold">R$ {{ number_format($course->discount_price ?? $course->price, 2, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Free Courses Section -->
@if($freeCourses->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Cursos Gratuitos</h2>
            <p class="text-muted">Comece a aprender sem gastar nada</p>
        </div>
        <div class="row">
            @foreach($freeCourses as $course)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card course-card h-100">
                        <img src="https://via.placeholder.com/300x150/17a2b8/ffffff?text={{ urlencode(Str::limit($course->title, 20)) }}" 
                             class="course-image" alt="{{ $course->title }}">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <span class="badge bg-success">Gratuito</span>
                            </div>
                            <h6 class="card-title">{{ Str::limit($course->title, 50) }}</h6>
                            <small class="text-muted mb-2">{{ $course->instructor->name }}</small>
                            <div class="mt-auto">
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-success btn-sm w-100">Começar Agora</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
    <div class="container text-center text-white">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-4">Pronto para Começar sua Jornada de Aprendizado?</h2>
                <p class="lead mb-4">
                    Junte-se a milhares de estudantes que já transformaram suas carreiras com nossos cursos.
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        Cadastre-se Grátis
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">
                        Explorar Cursos
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

