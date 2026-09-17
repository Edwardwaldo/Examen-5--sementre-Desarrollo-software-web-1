<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;

// Ruta raíz → redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// ── Autenticación ─────────────────────────────────────────
Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Rutas protegidas (requieren sesión activa) ────────────
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestión de Usuarios
    Route::resource('users', UserController::class)->except(['show']);

    // Gestión de Productos
    Route::resource('products', ProductController::class)->except(['show']);

    // Gestión de Clientes
    Route::resource('clients', ClientController::class)->except(['show']);
});
