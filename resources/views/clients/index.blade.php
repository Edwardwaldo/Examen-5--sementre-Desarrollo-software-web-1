@extends('layouts.app')

@section('title', 'Clientes')
@section('page-title', 'Gestión de Clientes')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-building me-2 text-warning"></i>Listado de Clientes</span>
        <a href="{{ route('clients.create') }}" class="btn btn-warning btn-sm text-white">
            <i class="bi bi-plus-circle me-1"></i>Nuevo Cliente
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>RUT Empresa</th>
                        <th>Razón Social</th>
                        <th>Rubro</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->rut_empresa }}</td>
                        <td>{{ $client->razon_social }}</td>
                        <td><span class="badge bg-secondary">{{ $client->rubro }}</span></td>
                        <td>
                            {{ $client->nombre_contacto }}<br>
                            <small class="text-muted">{{ $client->email_contacto }}</small>
                        </td>
                        <td>{{ $client->telefono }}</td>
                        <td class="text-center">
                            <a href="{{ route('clients.edit', $client->id) }}"
                               class="btn btn-sm btn-outline-warning btn-action me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar cliente {{ $client->razon_social }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay clientes registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
