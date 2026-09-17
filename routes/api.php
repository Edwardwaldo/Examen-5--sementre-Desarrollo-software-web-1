<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes — VentasFix
|--------------------------------------------------------------------------
| Prefijo base: /api
| Autenticación: Laravel Sanctum (Bearer Token)
|
| Rutas públicas:   POST /api/login
| Rutas protegidas: todo lo demás (requieren Authorization: Bearer {token})
*/

// ── Autenticación (pública) ───────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ── Rutas protegidas (requieren token Sanctum) ────────────
Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // CRUD Usuarios
    Route::apiResource('users', UserController::class);

    // CRUD Productos
    Route::apiResource('products', ProductController::class);

    // CRUD Clientes
    Route::apiResource('clients', ClientController::class);
});
