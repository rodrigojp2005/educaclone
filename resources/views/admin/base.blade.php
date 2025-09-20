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
        .mb-0{ margin-bottom:0; } .mb-1{ margin-bottom:.25rem; } .mb-3{ margin-bottom:1rem; } .mb-4{ margin-bottom:1.5rem; }
        .me-2{ margin-right:.5rem; }
        .row{ display:flex; flex-wrap:wrap; margin-left:-.5rem; margin-right:-.5rem; }
        .col, .col-12, .col-lg-4, .col-lg-6, .col-lg-12, .col-md-6, .col-xl-3 { padding-left:.5rem; padding-right:.5rem; }
        .col{ flex:1 0 0; }
        .col-12{ flex:0 0 100%; max-width:100%; }
        .col-lg-6{ flex:0 0 100%; max-width:100%; }
        .col-lg-12{ flex:0 0 100%; max-width:100%; }
        .col-lg-4{ flex:0 0 100%; max-width:100%; }
        .col-md-6{ flex:0 0 100%; max-width:100%; }
        .col-xl-3{ flex:0 0 100%; max-width:100%; }
        @media(min-width:768px){ .col-md-6{ flex:0 0 50%; max-width:50%; } }
        @media(min-width:992px){ .col-lg-6{ flex:0 0 50%; max-width:50%; } .col-lg-4{ flex:0 0 33.3333%; max-width:33.3333%; } .col-lg-12{ flex:0 0 100%; max-width:100%; } }
        @media(min-width:1200px){ .col-xl-3{ flex:0 0 25%; max-width:25%; } }
        .shadow{ box-shadow: 0 1px 2px rgba(0,0,0,.05), 0 1px 1px rgba(0,0,0,.02); }
        .border-bottom{ border-bottom:1px solid #e5e7eb; }
        .container-fluid{ width:100%; margin:0 auto; }
        .btn-close{ float:right; border:none; background:transparent; font-size:1.2rem; }
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
                <div class="mb-3 text-white fw-semibold">Menu</div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="fa-solid fa-users me-2"></i>Usuários</a>
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="fa-solid fa-tags me-2"></i>Categorias</a>
                    <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}"><i class="fa-solid fa-graduation-cap me-2"></i>Cursos</a>
                </nav>
            </aside>
            <main class="col-12 col-md-9 col-lg-10 admin-content">
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <h1 class="h4 mb-0">@yield('page-title', 'Dashboard')</h1>
                    <div>@yield('page-actions')</div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">×</button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sem JS externo; se app.js tiver Bootstrap, ele cobrirá; caso contrário, o layout básico funciona sem JS -->
    @yield('scripts')
</body>
</html>
