<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'EducaClone') }}</title>

    <!-- sentinel: ADMIN-BASE-LOADED -->

    <!-- Fallback CSS (minimal) so the page is usable even if CDN/Vite fail -->
    <style>
        :root { --admin-bg:#f8fafc; --admin-primary:#0d6efd; --admin-text:#0f172a; }
        body { background: var(--admin-bg); color: var(--admin-text); }
        .admin-navbar { background: #111827; color:#fff; }
        .admin-navbar a { color:#e5e7eb; text-decoration:none; }
        .admin-navbar a:hover { color:#fff; }
        .admin-sidebar { background:#1f2937; min-height:100vh; }
        .admin-sidebar .nav-link { color:#94a3b8; padding:.65rem 1rem; display:block; }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover { color:#fff; background:#374151; }
        .admin-content { padding: 1rem; }
        .card { background:#fff; border:1px solid #e5e7eb; border-radius:.5rem; }
        .card .card-header { border-bottom:1px solid #e5e7eb; padding:.75rem 1rem; background:#fff; }
        .card .card-body { padding:1rem; }
        .badge { padding:.35em .6em; border-radius:.35rem; font-size:.75rem; }
        .badge.bg-primary{ background:#0d6efd; color:#fff; }
        .badge.bg-warning{ background:#f59e0b; color:#111827; }
        .badge.bg-danger{ background:#ef4444; color:#fff; }
        .badge.bg-info{ background:#0ea5e9; color:#fff; }
        .text-muted { color:#6b7280 !important; }
        .text-white-50 { color: rgba(255,255,255,.5) !important; }
        .fw-bold { font-weight: 700 !important; }
        .mb-0{ margin-bottom:0; } .mb-1{ margin-bottom:.25rem; } .mb-3{ margin-bottom:1rem; } .mb-4{ margin-bottom:1.5rem; }
        .me-2{ margin-right:.5rem; }
        .py-2{ padding-top:.5rem; padding-bottom:.5rem; }
        .px-3{ padding-left:1rem; padding-right:1rem; }
        .px-md-4{ padding-left:1rem; padding-right:1rem; }
        .gap-3{ gap:1rem; }
        .d-flex{ display:flex; }
        .justify-content-between{ justify-content: space-between; }
        .align-items-center{ align-items: center; }
        .row{ display:flex; flex-wrap:wrap; margin-left:-.5rem; margin-right:-.5rem; }
        .col, .col-12, .col-lg-2, .col-lg-4, .col-lg-6, .col-lg-10, .col-lg-12, .col-md-3, .col-md-6, .col-md-9, .col-xl-3 { padding-left:.5rem; padding-right:.5rem; }
        .col{ flex:1 0 0; }
        .col-12{ flex:0 0 100%; max-width:100%; }
        .col-lg-6{ flex:0 0 100%; max-width:100%; }
        .col-lg-12{ flex:0 0 100%; max-width:100%; }
        .col-lg-4{ flex:0 0 100%; max-width:100%; }
        .col-md-6{ flex:0 0 100%; max-width:100%; }
        .col-xl-3{ flex:0 0 100%; max-width:100%; }
        @media(min-width:768px){
            .px-md-4{ padding-left:1.5rem; padding-right:1.5rem; }
            .col-md-3{ flex:0 0 25%; max-width:25%; }
            .col-md-6{ flex:0 0 50%; max-width:50%; }
            .col-md-9{ flex:0 0 75%; max-width:75%; }
        }
        @media(min-width:992px){
            .col-lg-2{ flex:0 0 16.6667%; max-width:16.6667%; }
            .col-lg-4{ flex:0 0 33.3333%; max-width:33.3333%; }
            .col-lg-6{ flex:0 0 50%; max-width:50%; }
            .col-lg-10{ flex:0 0 83.3333%; max-width:83.3333%; }
            .col-lg-12{ flex:0 0 100%; max-width:100%; }
        }
        @media(min-width:1200px){ .col-xl-3{ flex:0 0 25%; max-width:25%; } }
        .shadow{ box-shadow: 0 1px 2px rgba(0,0,0,.05), 0 1px 1px rgba(0,0,0,.02); }
        .border-bottom{ border-bottom:1px solid #e5e7eb; }
        .container-fluid{ width:100%; margin:0 auto; }
        .btn-close{ float:right; border:none; background:transparent; font-size:1.2rem; }
        /* Alerts minimal */
        .alert{ position:relative; padding:.75rem 1rem; border:1px solid transparent; border-radius:.375rem; margin-bottom:1rem; }
        .alert-success{ color:#0f5132; background:#d1e7dd; border-color:#badbcc; }
        .alert-danger{ color:#842029; background:#f8d7da; border-color:#f5c2c7; }
    </style>

    <!-- Removido dependências CDN para modo zero-CDN; os ícones usam classes de texto como fallback -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('head')
</head>
<body>
    <nav class="admin-navbar py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center px-3 px-md-4">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ url('/') }}" class="fw-bold">{{ config('app.name', 'EducaClone') }}</a>
                <span class="text-white-50">Admin</span>
            </div>
            <div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('admin-logout').submit();">Sair</a>
                <form id="admin-logout" method="POST" action="{{ route('logout') }}" class="d-none">@csrf</form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-12 col-md-3 col-lg-2 admin-sidebar p-3">
                <!DOCTYPE html>
                <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta name="csrf-token" content="{{ csrf_token() }}">

                    <title>@yield('title', 'Área do Administrador') - {{ config('app.name', 'Udemy Clone') }}</title>

                    <!-- sentinel: ADMIN-BASE-LOADED -->

                    <!-- Fonts -->
                    <link rel="preconnect" href="https://fonts.bunny.net">
                    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

                    <!-- Bootstrap CSS (mesma versão do instrutor) -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <!-- Font Awesome (mesma versão do instrutor) -->
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

                    <!-- Scripts de app -->
                    @vite(['resources/css/app.css', 'resources/js/app.js'])

                    <style>
                        .sidebar { min-height: 100vh; background: #1f2937; }
                        .sidebar .nav-link { color: #94a3b8; padding: 0.75rem 1rem; }
                        .sidebar .nav-link:hover { color: #fff; background-color: #374151; }
                        .sidebar .nav-link.active { color: #fff; background-color: #2563eb; }
                        .main-content { margin-left: 0; }
                        @media (min-width: 768px) { .main-content { margin-left: 250px; } }
                    </style>
                    @yield('head')
                   </head>
                <body class="bg-light">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- Sidebar -->
                            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                                <div class="position-sticky pt-3">
                                    <div class="text-center mb-4">
                                        <h5 class="text-white">Admin</h5>
                                    </div>

                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                               href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-gauge-high me-2"></i>
                                                Dashboard
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                               href="{{ route('admin.users.index') }}">
                                                <i class="fas fa-users me-2"></i>
                                                Usuários
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                                               href="{{ route('admin.categories.index') }}">
                                                <i class="fas fa-tags me-2"></i>
                                                Categorias
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}"
                                               href="{{ route('admin.courses.index') }}">
                                                <i class="fas fa-graduation-cap me-2"></i>
                                                Cursos
                                            </a>
                                        </li>
                                        <li class="nav-item"><hr class="text-muted"></li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('home') }}">
                                                <i class="fas fa-home me-2"></i>
                                                Voltar ao Site
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="nav-link btn btn-link text-start w-100 border-0">
                                                    <i class="fas fa-sign-out-alt me-2"></i>
                                                    Sair
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </nav>

                            <!-- Main content -->
                            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                                <!-- Header -->
                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                                    <h1 class="h2">@yield('page-title','Painel do Administrador')</h1>
                                    <div class="btn-toolbar mb-2 mb-md-0">
                                        @yield('page-actions')
                                    </div>
                                </div>

                                <!-- Alerts -->
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

                                <!-- Content -->
                                @yield('content')
                            </main>
                        </div>
                    </div>

                    <!-- Bootstrap JS -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                    @yield('scripts')
                </body>
                </html>
