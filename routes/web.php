<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\DisertanteController;
use App\Http\Controllers\DisciplinaController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\AcreditadoController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\MovimientosController;

// Login (público)
Route::get('/login', [UsuarioController::class, 'loginForm'])->name('login');
Route::post('/login', [UsuarioController::class, 'login']);
Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Registro público de acreditados (únicas rutas sin auth)
Route::get('/acreditaciones/form', [AcreditadoController::class, 'create'])->name('acreditaciones.form');
Route::post('/acreditaciones/form', [AcreditadoController::class, 'store'])->name('acreditaciones.store');

// Perfil vía token (también sin login)
Route::get('/acreditaciones/perfil/{token}', [AcreditadoController::class, 'show'])->name('acreditaciones.show');

// Todo lo demás requiere autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas admin
    Route::prefix('admin')->group(function () {
        Route::get('/register-user', [UsuarioController::class, 'registerForm'])->name('admin.register-user');
        Route::post('/register-user', [UsuarioController::class, 'register']);

        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
        Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('admin.edit-usuario');
        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('admin.update-usuario');
        Route::patch('/usuarios/{usuario}/toggle', [UsuarioController::class, 'toggleInhabilitado'])->name('admin.toggle-usuario');
    });

    // Salas
    Route::resource('salas', SalaController::class);

    // Disertantes
    Route::resource('disertantes', DisertanteController::class);

    // Disciplinas
    Route::resource('disciplinas', DisciplinaController::class);

    // Eventos
    Route::resource('eventos', EventoController::class);

    // Acreditados (solo autenticados)
    Route::get('/acreditaciones', [AcreditadoController::class, 'index'])->name('acreditaciones.index');
    Route::get('/acreditaciones/{acreditado}/edit', [AcreditadoController::class, 'edit'])->name('acreditaciones.edit');
    Route::put('/acreditaciones/{acreditado}', [AcreditadoController::class, 'update'])->name('acreditaciones.update');
    Route::get('/acreditaciones/{acreditado}/qr', [AcreditadoController::class, 'qr'])->name('acreditaciones.qr');

    // Actividades
    Route::resource('actividades', ActividadController::class)
        ->parameters(['actividades' => 'actividad']);

    // Participantes
    Route::get('/participantes/{id_acreditado}/{id_actividad}', [ParticipanteController::class, 'marcarAsistencia']);
});
Route::get('/eventos/{evento}/actividades', [EventoController::class, 'actividades']);

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Movimientos
Route::middleware(['web'])->group(function () {
    Route::get('/movimientos', [MovimientosController::class, 'index'])->name('movimientos.index');
    Route::get('/movimientos/create', [MovimientosController::class, 'create'])->name('movimientos.create');
    Route::post('/movimientos', [MovimientosController::class, 'store'])->name('movimientos.store');

    // Inhabilitar
    Route::post('/movimientos/{id}/inhabilitar', [MovimientosController::class, 'inhabilitar'])->name('movimientos.inhabilitar');

    // AJAX: buscar acreditado por DNI
    Route::get('/acreditados/buscar', [AcreditadoController::class, 'buscar'])
    ->name('acreditados.buscar');
}); 