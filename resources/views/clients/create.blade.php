@extends('layouts.app')

@section('title', 'Nuevo Cliente')
@section('page-title', 'Crear Nuevo Cliente')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-building me-2 text-warning"></i>Datos del Cliente Empresa
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Datos de la Empresa</h6>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">RUT Empresa <span class="text-danger">*</span></label>
                    <input type="text" name="rut_empresa"
                           class="form-control @error('rut_empresa') is-invalid @enderror"
                           value="{{ old('rut_empresa') }}" placeholder="76123456-7" required>
                    @error('rut_empresa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">Razón Social <span class="text-danger">*</span></label>
                    <input type="text" name="razon_social"
                           class="form-control @error('razon_social') is-invalid @enderror"
                           value="{{ old('razon_social') }}" required>
                    @error('razon_social')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Rubro <span class="text-danger">*</span></label>
                    <input type="text" name="rubro"
                           class="form-control @error('rubro') is-invalid @enderror"
                           value="{{ old('rubro') }}" required>
                    @error('rubro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Teléfono <span class="text-danger">*</span></label>
                    <input type="text" name="telefono" class="form-control"
                           value="{{ old('telefono') }}" placeholder="+56912345678" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Dirección <span class="text-danger">*</span></label>
                    <input type="text" name="direccion" class="form-control"
                           value="{{ old('direccion') }}" required>
                </div>
            </div>

            <h6 class="text-muted fw-semibold mb-3 border-bottom pb-2">Persona de Contacto</h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nombre Contacto <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_contacto" class="form-control"
                           value="{{ old('nombre_contacto') }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email Contacto <span class="text-danger">*</span></label>
                    <input type="email" name="email_contacto" class="form-control"
                           value="{{ old('email_contacto') }}" required>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-warning text-white">
                    <i class="bi bi-save me-1"></i>Guardar Cliente
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
