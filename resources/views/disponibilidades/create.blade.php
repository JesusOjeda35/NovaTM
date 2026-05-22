@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-3xl">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Crear Nueva Consulta</h1>

    <form action="{{ route('consulta.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
        @csrf

        <!-- Animal -->
        <div class="mb-6">
            <label for="animales_id_animal" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-horse text-yellow-600"></i> Animal
            </label>
            <select name="animales_id_animal" id="animales_id_animal" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('animales_id_animal') border-red-500 @enderror">
                <option value="">Selecciona un animal</option>
                @foreach ($animales as $animal)
                    <option value="{{ $animal->id_animal }}" {{ old('animales_id_animal') == $animal->id_animal ? 'selected' : '' }}>
                        {{ $animal->nombre }} ({{ $animal->especie }})
                    </option>
                @endforeach
            </select>
            @error('animales_id_animal')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Tipo de Consulta -->
        <div class="mb-6">
            <label for="tipo_consulta" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-clipboard-list text-yellow-600"></i> Tipo de Consulta
            </label>
            <select name="tipo_consulta" id="tipo_consulta" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('tipo_consulta') border-red-500 @enderror">
                <option value="">Selecciona un tipo</option>
                <option value="General" {{ old('tipo_consulta') === 'General' ? 'selected' : '' }}>Consulta General</option>
                <option value="Odontología" {{ old('tipo_consulta') === 'Odontología' ? 'selected' : '' }}>Odontología</option>
                <option value="Cirugía" {{ old('tipo_consulta') === 'Cirugía' ? 'selected' : '' }}>Cirugía</option>
                <option value="Oftalmología" {{ old('tipo_consulta') === 'Oftalmología' ? 'selected' : '' }}>Oftalmología</option>
                <option value="Dermatología" {{ old('tipo_consulta') === 'Dermatología' ? 'selected' : '' }}>Dermatología</option>
                <option value="Urgencia" {{ old('tipo_consulta') === 'Urgencia' ? 'selected' : '' }}>Urgencia</option>
            </select>
            @error('tipo_consulta')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Motivo -->
        <div class="mb-6">
            <label for="motivo" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-pen text-yellow-600"></i> Motivo de la Consulta
            </label>
            <textarea name="motivo" id="motivo" rows="4"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('motivo') border-red-500 @enderror"
                placeholder="Describe el motivo de la consulta...">{{ old('motivo') }}</textarea>
            @error('motivo')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Urgencia -->
        <div class="mb-6">
            <label for="urgencia" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-exclamation-triangle text-yellow-600"></i> Nivel de Urgencia
            </label>
            <select name="urgencia" id="urgencia"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('urgencia') border-red-500 @enderror">
                <option value="">Selecciona un nivel</option>
                <option value="baja" {{ old('urgencia') === 'baja' ? 'selected' : '' }}>Baja</option>
                <option value="media" {{ old('urgencia') === 'media' ? 'selected' : '' }}>Media</option>
                <option value="alta" {{ old('urgencia') === 'alta' ? 'selected' : '' }}>Alta</option>
            </select>
            @error('urgencia')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Disponibilidad para agendar -->
        <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded">
            <h3 class="font-bold text-blue-800 mb-4"><i class="fas fa-calendar"></i> Agendar en Disponibilidad</h3>
            <p class="text-sm text-gray-600 mb-4">Si deseas agendar esta consulta en una disponibilidad existente, selecciona una:</p>
            
            <select id="disponibilidad_id"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <option value="">No agendar en disponibilidad</option>
                @foreach ($disponibilidades as $disp)
                    <option value="{{ $disp->id }}">
                        {{ $disp->user->nombre_completo }} - {{ $disp->especialidad }} ({{ $disp->dia_semana }} {{ $disp->hora_inicio }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                <i class="fas fa-save"></i> Crear Consulta
            </button>
            <a href="{{ route('profesional.consultas') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection