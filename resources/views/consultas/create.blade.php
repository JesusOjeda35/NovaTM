@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">📋 Crear Nueva Consulta</h1>

        <form action="{{ route('consulta.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-6">
            @csrf

            <!-- Disponibilidad preseleccionada (oculto) -->
            @if($disponibilidad_id)
                <input type="hidden" name="disponibilidad_id" value="{{ $disponibilidad_id }}">
                
                <!-- Mostrar info de la disponibilidad seleccionada -->
                @php
                    $disp = \App\Models\Disponibilidad::find($disponibilidad_id);
                @endphp
                
                @if($disp)
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded">
                        <p class="font-bold">✅ Disponibilidad Seleccionada:</p>
                        <p class="text-sm mt-1">
                            <strong>Profesional:</strong> {{ $disp->user->nombre_completo }} 
                            ({{ $disp->especialidad ?? 'Veterinario' }})
                        </p>
                        <p class="text-sm">
                            <strong>Día:</strong> {{ $disp->dia_semana }} - 
                            <strong>Hora:</strong> {{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($disp->hora_fin)->format('H:i') }}
                        </p>
                        <p class="text-sm">
                            <strong>Precio:</strong> ${{ number_format($disp->precio_consulta, 2) }}
                        </p>
                        <p class="text-sm mt-2">
                            <a href="{{ route('profesionales.buscar') }}" class="text-blue-600 hover:underline">
                                ← Cambiar disponibilidad
                            </a>
                        </p>
                    </div>
                @endif
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded">
                    <p class="font-bold">⚠️ Sin disponibilidad seleccionada</p>
                    <p class="text-sm mt-1">
                        <a href="{{ route('profesionales.buscar') }}" class="text-yellow-700 font-bold hover:underline">
                            → Selecciona una disponibilidad de profesional
                        </a>
                    </p>
                </div>
            @endif

            <!-- Animal -->
            <div class="mb-6">
                <label for="animales_id_animal" class="block text-sm font-bold text-gray-700 mb-2">
                    🐴 Animal
                </label>
                <select 
                    name="animales_id_animal" 
                    id="animales_id_animal"
                    class="w-full px-4 py-3 border @error('animales_id_animal') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    required
                >
                    <option value="">Selecciona un animal</option>
                    @forelse($animales as $animal)
                        <option value="{{ $animal->id_animal }}" @selected(old('animales_id_animal') == $animal->id_animal)>
                            {{ $animal->nombre }} ({{ $animal->especie }})
                        </option>
                    @empty
                        <option value="" disabled>No tienes animales registrados</option>
                    @endforelse
                </select>
                @error('animales_id_animal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo de Consulta -->
            <div class="mb-6">
                <label for="tipo_consulta" class="block text-sm font-bold text-gray-700 mb-2">
                    📌 Tipo de Consulta
                </label>
                <select 
                    name="tipo_consulta" 
                    id="tipo_consulta"
                    class="w-full px-4 py-3 border @error('tipo_consulta') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    required
                >
                    <option value="">Selecciona un tipo</option>
                    @foreach($tiposConsulta as $tipo)
                        <option value="{{ $tipo }}" @selected(old('tipo_consulta') == $tipo)>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
                @error('tipo_consulta')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Motivo de la Consulta -->
            <div class="mb-6">
                <label for="motivo" class="block text-sm font-bold text-gray-700 mb-2">
                    📝 Motivo de la Consulta
                </label>
                <textarea 
                    name="motivo" 
                    id="motivo"
                    rows="4"
                    class="w-full px-4 py-3 border @error('motivo') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    placeholder="Describe el motivo de la consulta..."
                >{{ old('motivo') }}</textarea>
                @error('motivo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nivel de Urgencia -->
            <div class="mb-6">
                <label for="urgencia" class="block text-sm font-bold text-gray-700 mb-2">
                    ⚠️ Nivel de Urgencia
                </label>
                <select 
                    name="urgencia" 
                    id="urgencia"
                    class="w-full px-4 py-3 border @error('urgencia') border-red-500 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
                    <option value="">Selecciona un nivel</option>
                    @foreach($nivelesUrgencia as $nivel)
                        <option value="{{ $nivel }}" @selected(old('urgencia') == $nivel)>
                            {{ $nivel }}
                        </option>
                    @endforeach
                </select>
                @error('urgencia')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Botones -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 px-4 rounded-lg transition"
                >
                    ✅ Crear Consulta
                </button>
                <a 
                    href="{{ route('productor.consultas') }}" 
                    class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-lg text-center transition"
                >
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection