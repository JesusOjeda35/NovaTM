@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <h1>Bienvenido {{ auth()->user()->nombre_completo }}</h1>
            <p class="text-muted">Rol: <strong>{{ ucfirst(auth()->user()->rol) }}</strong></p>

            @if(auth()->user()->rol === 'productor')
                <!-- DASHBOARD USUARIO NORMAL (PRODUCTOR) -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">👨‍🌾 Mi Ganado</h5>
                                <p class="card-text">Gestiona y visualiza tus animales</p>
                                <a href="{{ route('productor.animales') }}" class="btn btn-primary">
                                    Ver Animales
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">📋 Mis Consultas</h5>
                                <p class="card-text">Consultas veterinarias de tus animales</p>
                                <a href="{{ route('productor.consultas') }}" class="btn btn-info">
                                    Ver Consultas
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">💊 Mis Recetas</h5>
                                <p class="card-text">Recetas prescritas por profesionales</p>
                                <a href="{{ route('productor.recetas') }}" class="btn btn-success">
                                    Ver Recetas
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">💬 Mensajes</h5>
                                <p class="card-text">Comunícate con veterinarios</p>
                                <a href="{{ route('productor.mensajes') }}" class="btn btn-warning">
                                    Ver Mensajes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif(auth()->user()->rol === 'veterinario' || auth()->user()->rol === 'especialista')
                <!-- DASHBOARD VETERINARIO / ESPECIALISTA -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">🐄 Mis Pacientes</h5>
                                <p class="card-text">Gestiona tus pacientes</p>
                                <a href="{{ route('profesional.pacientes') }}" class="btn btn-primary">
                                    Ver Pacientes
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">📋 Consultas</h5>
                                <p class="card-text">Crea y gestiona consultas</p>
                                <a href="{{ route('profesional.consultas') }}" class="btn btn-info">
                                    Ver Consultas
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">💊 Recetas</h5>
                                <p class="card-text">Prescribe medicamentos</p>
                                <a href="{{ route('profesional.consultas') }}" class="btn btn-success">
                                    Nueva Receta
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">📊 Historiales</h5>
                                <p class="card-text">Historiales clínicos</p>
                                <a href="{{ route('profesional.historiales') }}" class="btn btn-secondary">
                                    Ver Historiales
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-body text-center">
                                <h5 class="card-title">💬 Mensajes</h5>
                                <p class="card-text">Comunícate con productores</p>
                                <a href="{{ route('profesional.mensajes') }}" class="btn btn-warning">
                                    Ver Mensajes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection