@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Receta Médica</h1>
        <div class="flex gap-2">
            <a href="{{ route('productor.recetas') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8 mb-6">
        <!-- Header -->
        <div class="mb-6 pb-6 border-b-2 border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $receta->animal->nombre }}</h2>
            <p class="text-gray-600"><strong>Profesional:</strong> Dr. {{ $receta->User->nombre_completo }} - {{ $receta->User->tarjeta_profesional }}</p>
            <p class="text-gray-600"><strong>Especialidad:</strong> {{ $receta->User->especialidad ?? 'N/A' }}</p>
            <p class="text-gray-600"><strong>Fecha:</strong> {{ $receta->fecha_emision->format('d/m/Y H:i') }}</p>
        </div>

        <!-- Datos del Animal -->
        <div class="bg-blue-50 rounded-lg p-6 mb-6 border-l-4 border-blue-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Datos del Animal y del Dueño</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 font-bold">🐄 Nombre:</p>
                    <p class="text-gray-800">{{ $receta->animal->nombre }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">🏷️ Especie:</p>
                    <p class="text-gray-800">{{ $receta->animal->especie }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">🔖 Raza:</p>
                    <p class="text-gray-800">{{ $receta->animal->raza ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">⚖️ Peso:</p>
                    <p class="text-gray-800">{{ $receta->animal->peso }} kg</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">📅 Edad:</p>
                    <p class="text-gray-800">{{ $receta->animal->edad }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">🏷️ Identificación:</p>
                    <p class="text-gray-800">{{ $receta->animal->identificacion_propia ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">❤️ Estado de Salud:</p>
                    <p class="text-gray-800">{{ $receta->animal->estado_salud ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 font-bold">📍 Fecha de Registro:</p>
                    <p class="text-gray-800">{{ $receta->animal->fecha_registro->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-orange-500">
            <h3 class="text-lg font-bold text-gray-800 mb-3">🩺 Diagnóstico</h3>
            <p class="text-gray-700 whitespace-pre-wrap">{{ $receta->diagnostico }}</p>
        </div>

        <!-- Indicaciones Generales -->
        @if ($receta->indicaciones_generales)
            <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-yellow-500">
                <h3 class="text-lg font-bold text-gray-800 mb-3">📋 Indicaciones Generales</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $receta->indicaciones_generales }}</p>
            </div>
        @endif

        <!-- Medicamentos -->
        <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-green-500">
            <h3 class="text-lg font-bold text-gray-800 mb-4">💊 Lista de Medicamentos Recetados</h3>
            @if ($receta->medicamentos->isEmpty())
                <p class="text-gray-600">No hay medicamentos en esta receta.</p>
            @else
                <div class="space-y-4">
                    @foreach ($receta->medicamentos as $med)
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-green-400 transition bg-gray-50">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600 font-bold text-sm">💊 Medicamento:</p>
                                    <p class="text-gray-800 font-semibold text-base">{{ $med->nombre_medicamento }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-bold text-sm">📏 Dosis:</p>
                                    <p class="text-gray-800">{{ $med->dosis }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-bold text-sm">💉 Vía de Administración:</p>
                                    <p class="text-gray-800">{{ $med->via_administracion ?? 'No especificada' }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 font-bold text-sm">⏰ Frecuencia:</p>
                                    <p class="text-gray-800">{{ $med->frecuencia }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-gray-600 font-bold text-sm">📅 Duración:</p>
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
            <div class="bg-yellow-50 rounded-lg p-6 mb-6 border-l-4 border-yellow-500">
                <h3 class="text-lg font-bold text-gray-800 mb-3">📝 Notas Adicionales</h3>
                <p class="text-gray-700 whitespace-pre-wrap">{{ $receta->notas_adicionales }}</p>
            </div>
        @endif

        <!-- Botones de Acción -->
        <div class="flex gap-4 mt-8">
            <a href="{{ route('recetas.pdf', $receta->id_receta) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded transition text-center">
                <i class="fas fa-download"></i> Descargar Receta (PDF)
            </a>
            <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition" onclick="compartirReceta()">
                <i class="fas fa-share"></i> Compartir
            </button>
        </div>
    </div>
</div>

<script>
function compartirReceta() {
    alert('Funcionalidad de compartir en construcción');
}
</script>
@endsection