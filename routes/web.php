<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistorialClinicoController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\PasswordResetController;

// ========== RUTAS PÚBLICAS (sin autenticación) ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Recuperación de contraseña
Route::get('/password/reset', [PasswordResetController::class, 'showEmailForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// APIs públicas
Route::get('/api/departamentos/{paisId}', [LocalidadController::class, 'getDepartamentos']);
Route::get('/api/municipios/{departamentoId}', [LocalidadController::class, 'getMunicipios']);

// ========== RUTAS PROTEGIDAS (requieren autenticación) ==========
Route::middleware('auth')->group(function () {
    
    // Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========== RUTAS DEL MENÚ (disponibles para todos los roles autenticados) ==========
    Route::get('/mis-animales', [AnimalController::class, 'index'])->name('productor.animales');
    Route::get('/mis-consultas', [ConsultaController::class, 'misConsultas'])->name('productor.consultas');
    Route::get('/mis-recetas', [RecetaController::class, 'misRecetas'])->name('productor.recetas');
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('productor.mensajes');

    // ========== USUARIO NORMAL (Productor) ==========
    Route::middleware(\App\Http\Middleware\CheckProductor::class)->group(function () {
        // Animales
        Route::get('/animales/crear', [AnimalController::class, 'create'])->name('animal.create');
        Route::post('/animales', [AnimalController::class, 'store'])->name('animal.store');
        Route::get('/animales/{animal}', [AnimalController::class, 'show'])->name('animal.show');
        Route::get('/animales/{animal}/editar', [AnimalController::class, 'edit'])->name('animal.edit');
        Route::put('/animales/{animal}', [AnimalController::class, 'update'])->name('animal.update');
        Route::delete('/animales/{animal}', [AnimalController::class, 'destroy'])->name('animal.destroy');

        // Consultas (ver propias)
        Route::get('/consultas/{consulta}', [ConsultaController::class, 'show'])->name('consulta.show');

        // Recetas (ver propias)
        Route::get('/recetas/{receta}', [RecetaController::class, 'show'])->name('receta.show');

        // Mensajes
        Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensaje.store');
        Route::get('/mensajes/{mensaje}', [MensajeController::class, 'show'])->name('mensaje.show');
    });

    // ========== VETERINARIO / ESPECIALISTA ==========
    Route::middleware(\App\Http\Middleware\CheckProfesional::class)->group(function () {
        // Pacientes
        Route::get('/mis-pacientes', [DashboardController::class, 'misPacientes'])->name('profesional.pacientes');

        // Consultas (ver, crear, editar)
        Route::get('/consultas', [ConsultaController::class, 'index'])->name('profesional.consultas');
        Route::get('/consultas/crear', [ConsultaController::class, 'create'])->name('consulta.create');
        Route::post('/consultas', [ConsultaController::class, 'store'])->name('consulta.store');
        Route::get('/consultas/{consulta}/editar', [ConsultaController::class, 'edit'])->name('consulta.edit');
        Route::put('/consultas/{consulta}', [ConsultaController::class, 'update'])->name('consulta.update');

        // Recetas (crear, editar)
        Route::get('/recetas', [RecetaController::class, 'index'])->name('profesional.recetas');
        Route::get('/recetas/crear', [RecetaController::class, 'create'])->name('receta.create');
        Route::post('/recetas', [RecetaController::class, 'store'])->name('receta.store');
        Route::get('/recetas/{receta}/editar', [RecetaController::class, 'edit'])->name('receta.edit');
        Route::put('/recetas/{receta}', [RecetaController::class, 'update'])->name('receta.update');
        Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])->name('receta.destroy');

        // Historiales clínicos
        Route::get('/historiales', [HistorialClinicoController::class, 'index'])->name('profesional.historiales');
        Route::post('/historiales', [HistorialClinicoController::class, 'store'])->name('historial.store');

        // Mensajes
        Route::get('/mensajes', [MensajeController::class, 'index'])->name('profesional.mensajes');
        Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensaje.store');
    });
});