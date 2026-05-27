@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalle de Receta</h1>
        <div class="flex gap-2">
            <a href="{{ route('profesional.recetas') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <a href="{{ route('recetas.pdf', $receta->id_receta) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                <i class="fas fa-download"></i> Descargar PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Panel Izquierdo -->
        <div class="lg:col-span-2">
            <!-- Animal y Productor -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $receta->animal->nombre }}</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 font-bold">Especie:</p>
                        <p class="text-gray-800">{{ $receta->animal->especie }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-bold">Raza:</p>
                        <p class="text-gray-800">{{ $receta->animal->raza ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-bold">Peso:</p>
                        <p class="text-gray-800">{{ $receta->animal->peso }} kg</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-bold">Edad:</p>
                        <p class="text-gray-800">{{ $receta->animal->edad }}</p>
                    </div>
                </div>
                <hr class="my-4">
                <div>
                    <p class="text-gray-600 font-bold">Productor:</p>
                    <p class="text-gray-800">{{ $receta->animal->user->nombre_completo }}</p>
                    <p class="text-gray-600 text-sm">{{ $receta->animal->user->email }}</p>
                </div>
            </div>

            <!-- Diagnóstico -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-orange-500">
                <h3 class="text-xl font-bold text-gray-800 mb-3"><i class="fas fa-stethoscope"></i> Diagnóstico</h3>
                <p class="text-gray-700">{{ $receta->diagnostico }}</p>
            </div>

            <!-- Indicaciones Generales -->
            @if ($receta->indicaciones_generales)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-blue-500">
                    <h3 class="text-xl font-bold text-gray-800 mb-3"><i class="fas fa-clipboard-list"></i> Indicaciones Generales</h3>
                    <p class="text-gray-700">{{ $receta->indicaciones_generales }}</p>
                </div>
            @endif

            <!-- Medicamentos -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 border-l-4 border-green-500">
                <h3 class="text-xl font-bold text-gray-800 mb-4"><i class="fas fa-pills"></i> Medicamentos</h3>
                @if ($receta->medicamentos->isEmpty())
                    <p class="text-gray-600">No hay medicamentos en esta receta.</p>
                @else
                    <div class="space-y-4">
                        @foreach ($receta->medicamentos as $med)
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-green-300 transition">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-gray-600 font-bold">Medicamento:</p>
                                        <p class="text-gray-800">{{ $med->nombre_medicamento }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-bold">Dosis:</p>
                                        <p class="text-gray-800">{{ $med->dosis }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-bold">Vía de Administración:</p>
                                        <p class="text-gray-800">{{ $med->via_administracion ?? 'No especificada' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600 font-bold">Frecuencia:</p>
                                        <p class="text-gray-800">{{ $med->frecuencia }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <p class="text-gray-600 font-bold">Duración:</p>
                                        <p class="text-gray-800">{{ $med->duracion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Notas Adicionales -->
            @if ($receta->notas_adicionales)
                <div class="bg-yellow-50 rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                    <h3 class="text-xl font-bold text-gray-800 mb-3"><i class="fas fa-sticky-note"></i> Notas Adicionales</h3>
                    <p class="text-gray-700">{{ $receta->notas_adicionales }}</p>
                </div>
            @endif
        </div>

        <!-- Panel Derecho -->
        <div>
            <!-- Estado -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Estado</h3>
                <span class="inline-block px-4 py-2 rounded-full text-white font-bold @if($receta->isActiva()) bg-green-500 @else bg-red-500 @endif">
                    {{ ucfirst($receta->estado) }}
                </span>
            </div>

            <!-- Información de la Receta -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Información</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-gray-600 font-bold text-sm">Creada:</p>
                        <p class="text-gray-800">{{ $receta->fecha_emision->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 font-bold text-sm">Medicamentos:</p>
                        <p class="text-gray-800">{{ $receta->medicamentos->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Acciones -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Acciones</h3>
                <div class="space-y-2">
                    <a href="{{ route('profesional.recetas.edit', $receta->id_receta) }}" class="block w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition text-center">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('profesional.recetas.destroy', $receta->id_receta) }}" method="POST" onsubmit="return confirm('¿Eliminar receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection