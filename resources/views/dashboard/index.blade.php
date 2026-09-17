@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    {{-- Card Usuarios --}}
    <div class="col-md-4">
        <div class="card stat-card users h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;flex-shrink:0;">
                    <i class="bi bi-people fs-3 text-primary"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Usuarios del sistema</p>
                    <h2 class="fw-bold mb-0">{{ $totalUsuarios }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-arrow-right me-1"></i>Ver usuarios
                </a>
            </div>
        </div>
    </div>

    {{-- Card Productos --}}
    <div class="col-md-4">
        <div class="card stat-card products h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;flex-shrink:0;">
                    <i class="bi bi-box fs-3 text-success"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Productos registrados</p>
                    <h2 class="fw-bold mb-0">{{ $totalProductos }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-success">
                    <i class="bi bi-arrow-right me-1"></i>Ver productos
                </a>
            </div>
        </div>
    </div>

    {{-- Card Clientes --}}
    <div class="col-md-4">
        <div class="card stat-card clients h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                     style="width:56px;height:56px;flex-shrink:0;">
                    <i class="bi bi-building fs-3 text-warning"></i>
                </div>
                <div>
                    <p class="text-muted small mb-0">Clientes empresa</p>
                    <h2 class="fw-bold mb-0">{{ $totalClientes }}</h2>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pt-0">
                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-outline-warning">
                    <i class="bi bi-arrow-right me-1"></i>Ver clientes
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Tabla resumen rápido --}}
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-activity me-2 text-primary"></i>Resumen del sistema
    </div>
    <div class="card-body">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr>
                    <th>Módulo</th>
                    <th class="text-center">Total registros</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="bi bi-people me-2 text-primary"></i>Usuarios</td>
                    <td class="text-center fw-bold">{{ $totalUsuarios }}</td>
                    <td class="text-center">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary btn-action">
                            <i class="bi bi-plus-circle me-1"></i>Agregar
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><i class="bi bi-box me-2 text-success"></i>Productos</td>
                    <td class="text-center fw-bold">{{ $totalProductos }}</td>
                    <td class="text-center">
                        <a href="{{ route('products.create') }}" class="btn btn-sm btn-success btn-action">
                            <i class="bi bi-plus-circle me-1"></i>Agregar
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><i class="bi bi-building me-2 text-warning"></i>Clientes</td>
                    <td class="text-center fw-bold">{{ $totalClientes }}</td>
                    <td class="text-center">
                        <a href="{{ route('clients.create') }}" class="btn btn-sm btn-warning btn-action">
                            <i class="bi bi-plus-circle me-1"></i>Agregar
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
