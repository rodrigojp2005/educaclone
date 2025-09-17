@extends('layout')

@section('title', 'Bem-vindo')

@section('content')
<section class="hero-section" style="background: linear-gradient(135deg, #6f2dbd, #7c3aed); color: #fff;">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">De vez enquando, um tutorial é tudo o que você precisa</h1>
                <p class="lead mb-4">Descubra tutoriais e cursos completos com os melhores instrutores. Por que são pessoas que entendem suas necessidades.</p>
                <div class="d-flex flex-wrap gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-play me-2"></i> Co começar Agora!
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">Ver Cursos</a>
                    @else
                        <a href="{{ route('courses.index') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-play me-2"></i> Continuar Aprendendo
                        </a>
                        <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">Ver Cursos</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-graduation-cap" style="font-size: 12rem; opacity: .25;"></i>
            </div>
        </div>
    </div>
 </section>

 <section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <h5 class="fw-bold mb-2"><i class="fas fa-layer-group me-2 text-primary"></i>Categorias</h5>
                    <p class="text-muted small mb-3">Navegue por áreas de conhecimento.</p>
                    <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <h5 class="fw-bold mb-2"><i class="fas fa-star me-2 text-warning"></i>Em Destaque</h5>
                    <p class="text-muted small mb-3">Cursos selecionados a dedo.</p>
                    <a href="{{ route('courses.index', ['sort'=>'popular']) }}" class="btn btn-sm btn-outline-primary">Ver populares</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <h5 class="fw-bold mb-2"><i class="fas fa-gift me-2 text-success"></i>Gratuitos</h5>
                    <p class="text-muted small mb-3">Comece sem pagar nada.</p>
                    <a href="{{ route('courses.index', ['free'=>1]) }}" class="btn btn-sm btn-outline-primary">Ver grátis</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 bg-white shadow-sm rounded h-100">
                    <h5 class="fw-bold mb-2"><i class="fas fa-user-graduate me-2 text-info"></i>Meus Cursos</h5>
                    <p class="text-muted small mb-3">Continue de onde parou.</p>
                    @auth
                        @if (Route::has('my-courses.index'))
                            <a href="{{ route('my-courses.index') }}" class="btn btn-sm btn-outline-primary">Acessar</a>
                        @else
                            <a href="{{ route('courses.index') }}" class="btn btn-sm btn-outline-primary">Acessar</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Entrar</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
 </section>
@endsection
