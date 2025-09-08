<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// Login
Route::get('/login', [UsuarioController::class, 'loginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Rutas admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/register-user', [UsuarioController::class, 'registerForm'])->name('admin.register-user');
    Route::post('/register-user', [UsuarioController::class, 'register']);

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
    Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('admin.edit-usuario');
    Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('admin.update-usuario');
    Route::patch('/usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleInhabilitado'])->name('admin.toggle-usuario');
});


use App\Http\Controllers\SalaController;

Route::resource('salas', SalaController::class);


use App\Http\Controllers\DisertanteController;

Route::resource('disertantes', DisertanteController::class);


use App\Http\Controllers\DisciplinaController;

Route::resource('disciplinas', DisciplinaController::class);

use App\Http\Controllers\EventoController;

Route::resource('eventos', EventoController::class);


use App\Http\Controllers\AcreditadoController;

// Administración de acreditados (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('/acreditaciones', [AcreditadoController::class, 'index'])->name('acreditaciones.index');
    Route::get('/acreditaciones/{acreditado}/edit', [AcreditadoController::class, 'edit'])->name('acreditaciones.edit');
    Route::put('/acreditaciones/{acreditado}', [AcreditadoController::class, 'update'])->name('acreditaciones.update');
    Route::get('/acreditaciones/{acreditado}/qr', [AcreditadoController::class, 'qr'])->name('acreditaciones.qr');
});

// Registro público de acreditados
Route::get('/acreditaciones/form', [AcreditadoController::class, 'create'])->name('acreditaciones.form');
Route::post('/acreditaciones/form', [AcreditadoController::class, 'store'])->name('acreditaciones.store');

// Perfil vía token (sin login)
Route::get('/acreditaciones/perfil/{token}', [AcreditadoController::class, 'show'])->name('acreditaciones.show');
