<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VentasFix — Iniciar Sesión</title>
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #2f80ed 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            width: 100%;
            max-width: 420px;
        }
        .login-header {
            background: #1e3a5f;
            border-radius: 16px 16px 0 0;
            padding: 32px;
            text-align: center;
        }
        .login-header h4 { color: #fff; font-weight: 700; margin: 0; }
        .login-header p { color: #b0c4de; font-size: 0.875rem; margin: 0; }
        .login-body { padding: 32px; }
        .btn-login {
            background: #2f80ed;
            border: none;
            padding: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .btn-login:hover { background: #1e3a5f; }
        .form-control:focus { border-color: #2f80ed; box-shadow: 0 0 0 .2rem rgba(47,128,237,.25); }
    </style>
</head>
<body>
<div class="login-card card">
    <div class="login-header">
        <i class="bi bi-box-seam fs-2 text-white mb-2 d-block"></i>
        <h4>VentasFix</h4>
        <p>Sistema de Gestión Backoffice</p>
    </div>
    <div class="login-body">
        @if ($errors->any())
            <div class="alert alert-danger py-2 mb-3">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="usuario@ventasfix.cl"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-semibold">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="••••••••"
                           required>
                </div>
            </div>

            <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('template/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
