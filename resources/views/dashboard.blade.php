@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        @if(session('status'))
            <div class="p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <h1 class="text-4xl font-bold text-gray-800 mb-2">Bienvenido, {{ auth()->user()->nombre_completo }}</h1>
        <p class="text-gray-600"><i class="fas fa-badge"></i> <strong>Rol:</strong> {{ ucfirst(auth()->user()->rol) }}</p>
    </div>

    @if(auth()->user()->rol === 'productor')
        <!-- DASHBOARD PRODUCTOR -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-yellow-400">
                <div class="text-center">
                    <i class="fas fa-cow text-4xl text-yellow-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mi Ganado</h5>
                    <p class="text-gray-600 mb-4">Gestiona y visualiza tus animales</p>
                    <a href="{{ route('productor.animales') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Animales
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-blue-400">
                <div class="text-center">
                    <i class="fas fa-clipboard-list text-4xl text-blue-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mis Consultas</h5>
                    <p class="text-gray-600 mb-4">Consultas veterinarias de tus animales</p>
                    <a href="{{ route('productor.consultas') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Consultas
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-green-400">
                <div class="text-center">
                    <i class="fas fa-pills text-4xl text-green-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mis Recetas</h5>
                    <p class="text-gray-600 mb-4">Recetas prescritas por profesionales</p>
                    <a href="{{ route('productor.recetas') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Recetas
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-purple-400">
                <div class="text-center">
                    <i class="fas fa-comments text-4xl text-purple-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mensajes</h5>
                    <p class="text-gray-600 mb-4">Comunícate con veterinarios</p>
                    <a href="{{ route('productor.mensajes') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Mensajes
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-orange-400">
                <div class="text-center">
                    <i class="fas fa-stethoscope text-4xl text-orange-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Buscar Profesional</h5>
                    <p class="text-gray-600 mb-4">Encuentra especialistas disponibles</p>
                    <a href="{{ route('profesionales.buscar') }}" class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-search"></i> Buscar
                    </a>
                </div>
            </div>
        </div>

    @elseif(auth()->user()->rol === 'veterinario' || auth()->user()->rol === 'especialista')
        <!-- DASHBOARD VETERINARIO / ESPECIALISTA -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-yellow-400">
                <div class="text-center">
                    <i class="fas fa-stethoscope text-4xl text-yellow-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mis Pacientes</h5>
                    <p class="text-gray-600 mb-4">Gestiona tus pacientes</p>
                    <a href="{{ route('profesional.pacientes') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Pacientes
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-blue-400">
                <div class="text-center">
                    <i class="fas fa-clipboard-list text-4xl text-blue-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Consultas</h5>
                    <p class="text-gray-600 mb-4">Crea y gestiona consultas</p>
                    <a href="{{ route('profesional.consultas') }}" class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Consultas
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-green-400">
                <div class="text-center">
                    <i class="fas fa-pills text-4xl text-green-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Recetas</h5>
                    <p class="text-gray-600 mb-4">Prescribe medicamentos</p>
                    <a href="{{ route('profesional.recetas') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-pills"></i> Ver Recetas
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-red-400">
                <div class="text-center">
                    <i class="fas fa-book-medical text-4xl text-red-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Historiales</h5>
                    <p class="text-gray-600 mb-4">Historiales clínicos</p>
                    <a href="{{ route('profesional.historiales') }}" class="inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Historiales
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-purple-400">
                <div class="text-center">
                    <i class="fas fa-comments text-4xl text-purple-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Mensajes</h5>
                    <p class="text-gray-600 mb-4">Comunícate con productores</p>
                    <a href="{{ route('productor.mensajes') }}" class="inline-block bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Mensajes
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-t-4 border-indigo-400">
                <div class="text-center">
                    <i class="fas fa-calendar-check text-4xl text-indigo-600 mb-4 block"></i>
                    <h5 class="text-xl font-bold text-gray-800 mb-2">Disponibilidades</h5>
                    <p class="text-gray-600 mb-4">Gestiona tus horarios</p>
                    <a href="{{ route('disponibilidades.index') }}" class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition">
                        <i class="fas fa-eye"></i> Ver Disponibilidades
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection