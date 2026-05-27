@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Mis Recetas Médicas</h1>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar - Historial de Recetas -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Historial de Recetas</h3>
                
                <!-- Buscar -->
                <input type="text" id="buscar-receta" placeholder="Buscar receta..." class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-4 focus:outline-none focus:border-blue-500">

                <!-- Filtro por Animal -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2 text-sm">Filtrar por animal:</label>
                    <select id="filtro-animal" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        <option value="">-- Todos los animales --</option>
                        @foreach ($recetas->unique('animales_id_animal')->values() as $receta)
                            <option value="{{ $receta->animal->id_animal }}">{{ $receta->animal->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Lista de Recetas -->
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @forelse ($recetas as $receta)
                        <a href="{{ route('productor.recetas.show', $receta->id_receta) }}" class="block p-3 rounded-lg hover:bg-blue-100 transition border-l-4 border-blue-500" data-animal="{{ $receta->animal->id_animal }}" data-receta="{{ $receta->animal->nombre }} {{ $receta->User->nombre_completo }}">
                            <div class="flex items-center gap-2 mb-2">
                                <img src="{{ $receta->animal->foto_url ?? 'https://via.placeholder.com/40' }}" alt="{{ $receta->animal->nombre }}" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-800 text-sm truncate">{{ $receta->animal->nombre }}</p>
                                    <p class="text-gray-600 text-xs">{{ $receta->fecha_emision->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 text-xs">Dr. {{ $receta->User->nombre_completo }}</p>
                        </a>
                    @empty
                        <p class="text-gray-600 text-sm p-4">No hay recetas disponibles</p>
                    @endforelse
                </div>

                @if ($recetas->count() > 5)
                    <button class="w-full mt-4 text-blue-600 hover:text-blue-800 font-bold text-sm">
                        Ver más recetas
                    </button>
                @endif
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="lg:col-span-3">
            @if ($recetas->isNotEmpty())
                @php $primeraReceta = $recetas->first(); @endphp
                <div class="bg-white rounded-lg shadow-md p-8">
                    <!-- Header -->
                    <div class="mb-6 pb-6 border-b-2 border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $primeraReceta->animal->nombre }}</h2>
                        <p class="text-gray-600"><strong>Profesional:</strong> Dr. {{ $primeraReceta->User->nombre_completo }}</p>
                        <p class="text-gray-600"><strong>Fecha:</strong> {{ $primeraReceta->fecha_emision->format('d/m/Y H:i') }}</p>
                    </div>

                    <!-- Datos del Animal -->
                    <div class="bg-blue-50 rounded-lg p-6 mb-6 border-l-4 border-blue-500">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Datos del Animal y del Dueño</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 font-bold">Nombre:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->nombre }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-bold">Especie:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->especie }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-bold">Raza:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->raza ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-bold">Peso:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->peso }} kg</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-bold">Edad:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->edad }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 font-bold">Identificación:</p>
                                <p class="text-gray-800">{{ $primeraReceta->animal->identificacion_propia ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Diagnóstico -->
                    <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-orange-500">
                        <h3 class="text-lg font-bold text-gray-800 mb-3">🩺 Diagnóstico</h3>
                        <p class="text-gray-700">{{ $primeraReceta->diagnostico }}</p>
                    </div>

                    <!-- Indicaciones Generales -->
                    @if ($primeraReceta->indicaciones_generales)
                        <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-yellow-500">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">📋 Indicaciones Generales</h3>
                            <p class="text-gray-700">{{ $primeraReceta->indicaciones_generales }}</p>
                        </div>
                    @endif

                    <!-- Medicamentos -->
                    <div class="bg-white rounded-lg p-6 mb-6 border-l-4 border-green-500">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">💊 Lista de Medicamentos Recetados por el Profesional</h3>
                        @if ($primeraReceta->medicamentos->isEmpty())
                            <p class="text-gray-600">No hay medicamentos en esta receta.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($primeraReceta->medicamentos as $med)
                                    <div class="border border-gray-200 rounded-lg p-4 hover:border-green-400 transition">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-gray-600 font-bold text-sm">💊 Medicamento:</p>
                                                <p class="text-gray-800 font-semibold">{{ $med->nombre_medicamento }}</p>
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
                    @if ($primeraReceta->notas_adicionales)
                        <div class="bg-yellow-50 rounded-lg p-6 mb-6 border-l-4 border-yellow-500">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">📝 Notas Adicionales</h3>
                            <p class="text-gray-700">{{ $primeraReceta->notas_adicionales }}</p>
                        </div>
                    @endif

                    <!-- Botones de Acción -->
                    <div class="flex gap-4 mt-8">
                        <a href="{{ route('recetas.pdf', $primeraReceta->id_receta) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded transition text-center">
                            <i class="fas fa-download"></i> Descargar Receta (PDF)
                        </a>
                        <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition" onclick="compartirReceta()">
                            <i class="fas fa-share"></i> Compartir
                        </button>
                    </div>
                </div>
            @else
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-8 rounded">
                    <p class="font-bold text-lg">No hay recetas disponibles</p>
                    <p class="text-sm mt-2">Los profesionales crearán recetas después de atender tus consultas</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Filtro por animal
document.getElementById('filtro-animal')?.addEventListener('change', function() {
    const animalId = this.value;
    document.querySelectorAll('[data-animal]').forEach(el => {
        el.style.display = !animalId || el.dataset.animal === animalId ? 'block' : 'none';
    });
});

// Búsqueda
document.getElementById('buscar-receta')?.addEventListener('keyup', function() {
    const busqueda = this.value.toLowerCase();
    document.querySelectorAll('[data-receta]').forEach(el => {
        el.style.display = el.dataset.receta.toLowerCase().includes(busqueda) ? 'block' : 'none';
    });
});

function compartirReceta() {
    alert('Funcionalidad de compartir en construcción');
}
</script>
@endsection