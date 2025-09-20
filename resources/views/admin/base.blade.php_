<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Painel Administrativo') - {{ config('app.name', 'Udemy Clone') }}</title>

    <!-- Fallback CSS first -->
    <style>
        .sidebar { min-height: 100vh; background: #343a40; }
        .sidebar .nav-link { color: #adb5bd; padding: 0.75rem 1rem; }
        .sidebar .nav-link:hover { color: #fff; background-color: #495057; }
        .sidebar .nav-link.active { color: #fff; background-color: #007bff; }
        .main-content { margin-left: 0; }
        @media (min-width: 768px) { .main-content { margin-left: 250px; } }
        /* Fallback components */
        .card { border: 1px solid #e0e0e0; border-radius: 0.5rem; background: #fff; margin-bottom: 1rem; }
        .card-header { padding: 0.75rem 1rem; border-bottom: 1px solid #e9ecef; background: #f8f9fa; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; }
        .card-body { padding: 1rem; }
        .shadow { box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15); }
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
        .container-fluid { width: 100%; padding-right: 1rem; padding-left: 1rem; margin-right: auto; margin-left: auto; }
        .btn { display: inline-block; font-weight: 600; padding: .375rem .75rem; border: 1px solid transparent; border-radius: .375rem; text-decoration: none; cursor: pointer; }
        .btn-outline-primary { color: #0d6efd; border-color: #0d6efd; background: transparent; }
        .btn-outline-primary:hover { color: #fff; background-color: #0d6efd; border-color: #0d6efd; }
        .btn-close { float: right; background: transparent; border: 0; font-size: 1.1rem; line-height: 1; }
        .alert { position: relative; padding: .75rem 1rem; border: 1px solid transparent; border-radius: .25rem; margin-bottom: 1rem; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
    </style>

    <!-- External CSS afterward (if available) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <!-- ADMIN-BASE-LOADED: comentário sentinela -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h5 class="text-white">Admin Panel</h5>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="fas fa-users me-2"></i> Usuários
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="fas fa-tags me-2"></i> Categorias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                                <i class="fas fa-graduation-cap me-2"></i> Cursos
                            </a>
                        </li>
                        <li class="nav-item"><hr class="text-muted"></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Voltar ao Site</a></li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">@csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100 border-0">
                                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">@yield('page-actions')</div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
