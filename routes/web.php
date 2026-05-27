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
use App\Http\Controllers\DisponibilidadController;

// ========== RUTAS PÚBLICAS (sin autenticación) ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// ========== AUTENTICACIÓN ==========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ========== RECUPERACIÓN DE CONTRASEÑA ==========
Route::get('/password/reset', [PasswordResetController::class, 'showEmailForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// ========== APIs PÚBLICAS ==========
Route::get('/api/departamentos/{paisId}', [LocalidadController::class, 'getDepartamentos']);
Route::get('/api/municipios/{departamentoId}', [LocalidadController::class, 'getMunicipios']);

// ========== RUTAS PROTEGIDAS (requieren autenticación) ==========
Route::middleware('auth')->group(function () {
    
    // ========== DASHBOARD Y LOGOUT ==========
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========== MENÚ GENERAL (disponible para todos los roles autenticados) ==========
    Route::get('/mis-animales', [AnimalController::class, 'index'])->name('productor.animales');
    Route::get('/mis-consultas', [ConsultaController::class, 'misConsultas'])->name('productor.consultas');
    Route::get('/mis-recetas', [RecetaController::class, 'misRecetas'])->name('productor.recetas');
    Route::get('/mensajes', [MensajeController::class, 'index'])->name('productor.mensajes');

    // ========== RUTAS PARA ANIMALES (disponibles para TODOS los usuarios autenticados) ==========
    Route::get('/animales/crear', [AnimalController::class, 'create'])->name('animal.create');
    Route::post('/animales', [AnimalController::class, 'store'])->name('animal.store');
    Route::get('/animales/{animal}', [AnimalController::class, 'show'])->name('animal.show');
    Route::get('/animales/{animal}/editar', [AnimalController::class, 'edit'])->name('animal.edit');
    Route::put('/animales/{animal}', [AnimalController::class, 'update'])->name('animal.update');
    Route::delete('/animales/{animal}', [AnimalController::class, 'destroy'])->name('animal.destroy');

    // ========== RUTAS PARA MENSAJES (disponibles para TODOS) ==========
    Route::post('/mensajes', [MensajeController::class, 'store'])->name('mensaje.store');
    Route::get('/mensajes/{mensaje}', [MensajeController::class, 'show'])->name('mensaje.show');

    // ========== BUSCAR PROFESIONALES (PARA PRODUCTORES Y PROFESIONALES) ==========
    Route::get('/profesionales/buscar', [ConsultaController::class, 'buscarProfesionales'])->name('profesionales.buscar');

    // ========== CREAR CONSULTA (disponible para PRODUCTORES) - DEBE IR ANTES DE {consulta} ==========
    Route::get('/consultas/crear', [ConsultaController::class, 'create'])->name('consulta.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consulta.store');

    // ========== CONSULTAS Y RECETAS (disponibles para TODOS) ==========
    Route::get('/consultas/{consulta}', [ConsultaController::class, 'show'])->name('consulta.show');
    Route::get('/recetas/{receta}', [RecetaController::class, 'show'])->name('receta.show');

    // ========== HISTORIALES CLÍNICOS ==========
    // IMPORTANTE: Las rutas sin parámetros DEBEN ir ANTES que las parametrizadas
    Route::get('/historiales', [HistorialClinicoController::class, 'index'])->name('historial.index');
    Route::get('/historiales/crear', [HistorialClinicoController::class, 'create'])->name('historial.create');
    Route::post('/historiales', [HistorialClinicoController::class, 'store'])->name('historial.store');
    
    // Rutas parametrizadas (van DESPUÉS)
    Route::get('/historiales/{historialClinico}', [HistorialClinicoController::class, 'show'])->name('historial.show');
    Route::get('/historiales/{historialClinico}/editar', [HistorialClinicoController::class, 'edit'])->name('historial.edit');
    Route::put('/historiales/{historialClinico}', [HistorialClinicoController::class, 'update'])->name('historial.update');
    Route::delete('/historiales/{historialClinico}', [HistorialClinicoController::class, 'destroy'])->name('historial.destroy');

    // ========== RUTAS PARA PROFESIONALES (VETERINARIOS Y ESPECIALISTAS) ==========
    Route::middleware(\App\Http\Middleware\CheckProfesional::class)->group(function () {
        
        // ========== CONSULTAS ==========
        Route::get('/consultas', [ConsultaController::class, 'index'])->name('profesional.consultas');
        Route::post('/consultas/{consulta}/attend', [ConsultaController::class, 'attend'])->name('consulta.attend');
        Route::get('/consultas/{consulta}/editar', [ConsultaController::class, 'edit'])->name('consulta.edit');
        Route::put('/consultas/{consulta}', [ConsultaController::class, 'update'])->name('consulta.update');
        Route::delete('/consultas/{consulta}', [ConsultaController::class, 'destroy'])->name('consulta.destroy');

        // ========== DISPONIBILIDADES ==========
        Route::get('/disponibilidades', [DisponibilidadController::class, 'index'])->name('disponibilidades.index');
        Route::get('/disponibilidades/crear', [DisponibilidadController::class, 'create'])->name('disponibilidades.create');
        Route::post('/disponibilidades', [DisponibilidadController::class, 'store'])->name('disponibilidades.store');
        Route::get('/disponibilidades/{disponibilidad}/editar', [DisponibilidadController::class, 'edit'])->name('disponibilidades.edit');
        Route::put('/disponibilidades/{disponibilidad}', [DisponibilidadController::class, 'update'])->name('disponibilidades.update');
        Route::delete('/disponibilidades/{disponibilidad}', [DisponibilidadController::class, 'destroy'])->name('disponibilidades.destroy');

        // ========== PACIENTES ==========
        Route::get('/mis-pacientes', [DashboardController::class, 'misPacientes'])->name('profesional.pacientes');

        // ========== RECETAS ==========
        Route::get('/recetas', [RecetaController::class, 'index'])->name('profesional.recetas');
        Route::get('/recetas/crear', [RecetaController::class, 'create'])->name('receta.create');
        Route::post('/recetas', [RecetaController::class, 'store'])->name('receta.store');
        Route::get('/recetas/{receta}/editar', [RecetaController::class, 'edit'])->name('receta.edit');
        Route::put('/recetas/{receta}', [RecetaController::class, 'update'])->name('receta.update');
        Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])->name('receta.destroy');
    });
});