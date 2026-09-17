@extends('layouts.app')

@section('title', 'Productos')
@section('page-title', 'Gestión de Productos')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-box me-2 text-success"></i>Listado de Productos</span>
        <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle me-1"></i>Nuevo Producto
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Imagen</th>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Precio Neto</th>
                        <th>Precio Venta</th>
                        <th>Stock Actual</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->imagen)
                                <img src="{{ asset('storage/' . $product->imagen) }}"
                                     alt="{{ $product->nombre }}"
                                     width="48" height="48"
                                     style="object-fit:cover;border-radius:6px;">
                            @else
                                <span class="badge bg-secondary">Sin imagen</span>
                            @endif
                        </td>
                        <td><code>{{ $product->sku }}</code></td>
                        <td>{{ $product->nombre }}</td>
                        <td>${{ number_format($product->precio_neto, 0, ',', '.') }}</td>
                        <td class="fw-semibold text-success">${{ number_format($product->precio_venta, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $product->stock_actual <= $product->stock_bajo ? 'bg-danger' : 'bg-success' }}">
                                {{ $product->stock_actual }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('products.edit', $product->id) }}"
                               class="btn btn-sm btn-outline-warning btn-action me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar producto {{ $product->nombre }}?')">
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
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>No hay productos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
