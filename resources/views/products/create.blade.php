@extends('layouts.app')

@section('title', 'Nuevo Producto')
@section('page-title', 'Crear Nuevo Producto')

@section('content')
<div class="card" style="max-width:780px;">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-box me-2 text-success"></i>Datos del Producto
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                           value="{{ old('sku') }}" required>
                    @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción Corta <span class="text-danger">*</span></label>
                    <input type="text" name="descripcion_corta" class="form-control @error('descripcion_corta') is-invalid @enderror"
                           value="{{ old('descripcion_corta') }}" maxlength="255" required>
                    @error('descripcion_corta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Descripción Larga <span class="text-danger">*</span></label>
                    <textarea name="descripcion_larga" rows="3"
                              class="form-control @error('descripcion_larga') is-invalid @enderror"
                              required>{{ old('descripcion_larga') }}</textarea>
                    @error('descripcion_larga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Imagen del Producto <span class="text-danger">*</span></label>
                    <input type="file" name="imagen" accept="image/*"
                           class="form-control @error('imagen') is-invalid @enderror" required>
                    <div class="form-text">Formatos: JPG, PNG, WebP. Máximo 2MB.</div>
                    @error('imagen')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio Neto ($) <span class="text-danger">*</span></label>
                    <input type="number" name="precio_neto" id="precio_neto"
                           class="form-control @error('precio_neto') is-invalid @enderror"
                           value="{{ old('precio_neto') }}" min="0" step="1" required>
                    @error('precio_neto')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Precio Venta (IVA 19%)</label>
                    <input type="text" id="precio_venta_display" class="form-control bg-light" readonly
                           placeholder="Calculado automáticamente">
                    <div class="form-text text-success fw-semibold">Se calcula: precio neto × 1.19</div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Actual <span class="text-danger">*</span></label>
                    <input type="number" name="stock_actual" class="form-control"
                           value="{{ old('stock_actual', 0) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Mínimo <span class="text-danger">*</span></label>
                    <input type="number" name="stock_minimo" class="form-control"
                           value="{{ old('stock_minimo', 0) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Bajo <span class="text-danger">*</span></label>
                    <input type="number" name="stock_bajo" class="form-control"
                           value="{{ old('stock_bajo', 0) }}" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stock Alto <span class="text-danger">*</span></label>
                    <input type="number" name="stock_alto" class="form-control"
                           value="{{ old('stock_alto', 0) }}" min="0" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save me-1"></i>Guardar Producto
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
    // Calcular precio de venta en tiempo real
    document.getElementById('precio_neto').addEventListener('input', function () {
        const neto = parseFloat(this.value) || 0;
        const venta = Math.round(neto * 1.19);
        document.getElementById('precio_venta_display').value =
            venta > 0 ? '$' + venta.toLocaleString('es-CL') : '';
    });
</script>
@endsection
