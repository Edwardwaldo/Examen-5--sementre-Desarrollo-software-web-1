@extends('layouts.app')

@section('title', 'Editar Producto')
@section('page-title', 'Editar Producto')

@section('content')
<div class="card" style="max-width:780px;">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-pencil-square me-2 text-warning"></i>Editar: {{ $product->nombre }}
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                           value="{{ old('sku', $product->sku) }}" required>
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $product->nombre) }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción Corta <span class="text-danger">*</span></label>
                    <input type="text" name="descripcion_corta" class="form-control"
                           value="{{ old('descripcion_corta', $product->descripcion_corta) }}" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción Larga <span class="text-danger">*</span></label>
                    <textarea name="descripcion_larga" rows="3" class="form-control" required>{{ old('descripcion_larga', $product->descripcion_larga) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Imagen del Producto</label>
                    @if($product->imagen)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->imagen) }}"
                                 alt="Imagen actual" width="80" height="80"
                                 style="object-fit:cover;border-radius:8px;border:1px solid #dee2e6;">
                            <small class="text-muted ms-2">Imagen actual</small>
                        </div>
                    @endif
                    <input type="file" name="imagen" accept="image/*" class="form-control">
                    <div class="form-text">Deja vacío para mantener la imagen actual.</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio Neto ($) <span class="text-danger">*</span></label>
                    <input type="number" name="precio_neto" id="precio_neto"
                           class="form-control" value="{{ old('precio_neto', $product->precio_neto) }}"
                           min="0" step="1" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio Venta (IVA 19%)</label>
                    <input type="text" id="precio_venta_display" class="form-control bg-light" readonly
                           value="${{ number_format($product->precio_venta, 0, ',', '.') }}">
                    <div class="form-text text-success fw-semibold">Se recalcula automáticamente</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Actual <span class="text-danger">*</span></label>
                    <input type="number" name="stock_actual" class="form-control"
                           value="{{ old('stock_actual', $product->stock_actual) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Mínimo <span class="text-danger">*</span></label>
                    <input type="number" name="stock_minimo" class="form-control"
                           value="{{ old('stock_minimo', $product->stock_minimo) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Bajo <span class="text-danger">*</span></label>
                    <input type="number" name="stock_bajo" class="form-control"
                           value="{{ old('stock_bajo', $product->stock_bajo) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Alto <span class="text-danger">*</span></label>
                    <input type="number" name="stock_alto" class="form-control"
                           value="{{ old('stock_alto', $product->stock_alto) }}" min="0" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-save me-1"></i>Actualizar Producto
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('precio_neto').addEventListener('input', function () {
        const neto = parseFloat(this.value) || 0;
        const venta = Math.round(neto * 1.19);
        document.getElementById('precio_venta_display').value =
            venta > 0 ? '$' + venta.toLocaleString('es-CL') : '';
    });
</script>
@endsection
