<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Aprenda Online') - {{ config('app.name', 'Udemy Clone') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #a435f0;
            --secondary-color: #5624d0;
            --success-color: #73bc00;
            --warning-color: #f69c08;
            --danger-color: #e74c3c;
            --dark-color: #1c1d1f;
            --light-color: #f7f9fa;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 80px 0;
        }

        .course-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 8px;
            overflow: hidden;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .course-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .rating-stars {
            color: #f69c08;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e0e0e0;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .stats-section {
            background-color: var(--light-color);
            padding: 60px 0;
        }

        .stat-item {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            color: white;
            margin-bottom: 1rem;
        }

        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }

        .price-tag {
            font-weight: 700;
            font-size: 1.1rem;
        }

        .price-original {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
        }

        /* Fix: garantir navbar visível no desktop mesmo com CSS de terceiros */
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-collapse.collapse {
                display: flex !important;
                visibility: visible !important;
            }
        }

        /* Fix: Tailwind's .collapse utility conflicts with Bootstrap's accordion */
        .accordion .collapse { visibility: visible !important; }
        .accordion .collapse:not(.show) { display: none; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex flex-column flex-lg-row align-items-lg-center" href="{{ route('home') }}">
                <span>
                    <i class="fas fa-graduation-cap me-2"></i>
                    TutoCursos
                    <span class="d-block d-lg-inline fst-italic" style="font-weight: normal; font-size: 1rem;">
                        tudo em tutoriais e cursos!
                    </span>
                </span>
            </a>

            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNav" aria-controls="mobileNav" aria-label="Abrir menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Início</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categorias
                        </a>
                        <ul class="dropdown-menu">
                            @forelse(($navCategories ?? []) as $cat)
                                <li>
                                    <a class="dropdown-item" href="{{ route('courses.index', ['category' => $cat->slug]) }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item-text text-muted">Sem categorias</span></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses.index') }}">Cursos</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('my-courses.index') }}">Meus Cursos</a>
                    </li>
                    @endauth
                </ul>

                <!-- Search Bar -->
                <form class="d-flex me-3 search-bar" method="GET" action="{{ route('courses.index') }}">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar cursos..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">Cadastrar</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('my-courses.index') }}">Meus Cursos</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                @if(method_exists(Auth::user(), 'isInstructor') && Auth::user()->isInstructor())
                                    <li><a class="dropdown-item" href="{{ route('instructor.dashboard') }}">Área do Instrutor</a></li>
                                @endif
                                @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>

            <!-- Offcanvas Mobile Menu (hidden on >= lg to avoid duplicate desktop nav) -->
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="mobileNav" aria-labelledby="mobileNavLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="mobileNavLabel">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav mb-3">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('courses.index') }}">Cursos</a></li>
                        @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('my-courses.index') }}">Meus Cursos</a></li>
                        @endauth
                    </ul>
                    <form class="d-flex mb-3" method="GET" action="{{ route('courses.index') }}">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Buscar cursos..." aria-label="Buscar cursos">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                    <hr>
                    <ul class="navbar-nav">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Entrar</a></li>
                            <li class="nav-item mt-2"><a class="btn btn-primary w-100" href="{{ route('register') }}">Cadastrar</a></li>
                        @else
                            <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">Perfil</a></li>
                            @if(method_exists(Auth::user(), 'isInstructor') && Auth::user()->isInstructor())
                                <li class="nav-item"><a class="nav-link" href="{{ route('instructor.dashboard') }}">Área do Instrutor</a></li>
                            @endif
                            @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Painel Admin</a></li>
                            @endif
                            <li class="nav-item mt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">Sair</button>
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>EduClone</h5>
                    <p class="text-muted">
                        A melhor plataforma de cursos online do Brasil. 
                        Aprenda com os melhores instrutores e transforme sua carreira.
                    </p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Empresa</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Sobre nós</a></li>
                        <li><a href="#">Carreiras</a></li>
                        <li><a href="#">Imprensa</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Comunidade</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Instrutores</a></li>
                        <li><a href="#">Estudantes</a></li>
                        <li><a href="#">Desenvolvedores</a></li>
                        <li><a href="#">Afiliados</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Suporte</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Central de Ajuda</a></li>
                        <li><a href="#">Contato</a></li>
                        <li><a href="#">Política de Privacidade</a></li>
                        <li><a href="#">Termos de Uso</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Ensine</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Torne-se Instrutor</a></li>
                        <li><a href="#">Recursos de Ensino</a></li>
                        <li><a href="#">Políticas</a></li>
                        <li><a href="#">Ajuda para Instrutores</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} EduClone. Todos os direitos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="text-muted">Feito com ❤️ no Brasil</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fallback: se largura >= lg e a navbar estiver colapsada, forçar exibição
        document.addEventListener('DOMContentLoaded', function() {
            function ensureNavbarVisible() {
                if (window.innerWidth >= 992) {
                    var nav = document.getElementById('navbarNav');
                    if (nav && !nav.classList.contains('show')) {
                        nav.classList.add('show');
                    }
                }
            }
            ensureNavbarVisible();
            window.addEventListener('resize', ensureNavbarVisible);
        });
    </script>
    @yield('scripts')
</body>
</html>

