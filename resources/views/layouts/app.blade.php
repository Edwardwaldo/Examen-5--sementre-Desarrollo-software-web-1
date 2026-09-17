<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>VentasFix — @yield('title', 'Backoffice')</title>

    {{-- Bootstrap 5 (del template proporcionado por la empresa) --}}
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- Estilos del template --}}
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">

    <style>
        body { background-color: #f4f6f9; }
        .sidebar { min-height: 100vh; background-color: #1e3a5f; }
        .sidebar .nav-link { color: #b0c4de; font-size: 0.95rem; padding: 10px 16px; border-radius: 6px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #2f80ed; color: #fff; }
        .sidebar .nav-link i { margin-right: 8px; }
        .sidebar-brand { color: #fff; font-weight: 700; font-size: 1.2rem; padding: 20px 16px; display: block; }
        .topbar { background-color: #fff; border-bottom: 1px solid #dee2e6; padding: 12px 24px; }
        .main-content { padding: 24px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .stat-card { border-left: 4px solid; }
        .stat-card.users { border-color: #2f80ed; }
        .stat-card.products { border-color: #27ae60; }
        .stat-card.clients { border-color: #e67e22; }
        .table-hover tbody tr:hover { background-color: #f0f4ff; }
        .btn-action { padding: 4px 10px; font-size: 0.82rem; }
    </style>
</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR --}}
    <nav class="sidebar d-flex flex-column p-2" style="width:240px; min-width:240px;">
        <a class="sidebar-brand mb-3" href="{{ route('dashboard') }}">
            <i class="bi bi-box-seam me-2"></i>VentasFix
        </a>
        <ul class="nav flex-column gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                   href="{{ route('users.index') }}">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                   href="{{ route('products.index') }}">
                    <i class="bi bi-box"></i> Productos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"
                   href="{{ route('clients.index') }}">
                    <i class="bi bi-building"></i> Clientes
                </a>
            </li>
        </ul>

        <div class="mt-auto p-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión
                </button>
            </form>
            <small class="text-secondary d-block text-center mt-2">
                {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
            </small>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="flex-grow-1 d-flex flex-column">
        {{-- Topbar --}}
        <div class="topbar d-flex align-items-center justify-content-between">
            <h6 class="mb-0 text-muted">@yield('page-title', 'Dashboard')</h6>
            <span class="badge bg-primary">{{ auth()->user()->email }}</span>
        </div>

        {{-- Alertas globales --}}
        <div class="main-content flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

{{-- Bootstrap JS --}}
<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>
@yield('scripts')
</body>
</html>
