@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Editar Disponibilidad</h1>

    <form action="{{ route('disponibilidades.update', $disponibilidad->id) }}" method="POST" class="bg-white rounded-lg shadow-md p-8">
        @csrf
        @method('PUT')

        <!-- Especialidad -->
        <div class="mb-6">
            <label for="especialidad" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-stethoscope text-yellow-600"></i> Especialidad
            </label>
            <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad', $disponibilidad->especialidad) }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('especialidad') border-red-500 @enderror">
            @error('especialidad')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Día de la semana -->
        <div class="mb-6">
            <label for="dia_semana" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-calendar text-yellow-600"></i> Día de la Semana
            </label>
            <select name="dia_semana" id="dia_semana" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('dia_semana') border-red-500 @enderror">
                <option value="Lunes" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Lunes' ? 'selected' : '' }}>Lunes</option>
                <option value="Martes" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Martes' ? 'selected' : '' }}>Martes</option>
                <option value="Miércoles" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                <option value="Jueves" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Jueves' ? 'selected' : '' }}>Jueves</option>
                <option value="Viernes" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Viernes' ? 'selected' : '' }}>Viernes</option>
                <option value="Sábado" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Sábado' ? 'selected' : '' }}>Sábado</option>
                <option value="Domingo" {{ old('dia_semana', $disponibilidad->dia_semana) === 'Domingo' ? 'selected' : '' }}>Domingo</option>
            </select>
            @error('dia_semana')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Hora de inicio -->
        <div class="mb-6">
            <label for="hora_inicio" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-clock text-yellow-600"></i> Hora de Inicio
            </label>
            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', $disponibilidad->hora_inicio) }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('hora_inicio') border-red-500 @enderror">
            @error('hora_inicio')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Hora de fin -->
        <div class="mb-6">
            <label for="hora_fin" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-clock text-yellow-600"></i> Hora de Fin
            </label>
            <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin', $disponibilidad->hora_fin) }}" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('hora_fin') border-red-500 @enderror">
            @error('hora_fin')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Precio -->
        <div class="mb-6">
            <label for="precio_consulta" class="block text-gray-700 font-bold mb-2">
                <i class="fas fa-dollar-sign text-green-600"></i> Precio de la Consulta
            </label>
            <input type="number" name="precio_consulta" id="precio_consulta" value="{{ old('precio_consulta', $disponibilidad->precio_consulta) }}" 
                step="0.01" min="0" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 @error('precio_consulta') border-red-500 @enderror">
            @error('precio_consulta')
                <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
            @enderror
        </div>

        <!-- Estado activo -->
        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
            <label for="activo" class="flex items-center cursor-pointer">
                <input type="checkbox" name="activo" id="activo" value="1" 
                    {{ old('activo', $disponibilidad->activo) ? 'checked' : '' }}
                    class="w-5 h-5 text-yellow-600 rounded focus:ring-2 focus:ring-yellow-400">
                <span class="ml-3 text-gray-700 font-semibold"><i class="fas fa-check-circle text-green-600"></i> Disponibilidad Activa</span>
            </label>
        </div>

        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                <i class="fas fa-save"></i> Actualizar Disponibilidad
            </button>
            <a href="{{ route('disponibilidades.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-6 rounded-lg text-center transition">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>
@endsection