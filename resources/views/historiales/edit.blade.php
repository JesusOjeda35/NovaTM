@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">✏️ Editar Historial Clínico</h1>

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-600 text-red-800 rounded">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('historial.update', $historial->id_historial) }}" method="POST" class="bg-white rounded-lg shadow-lg p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- LADO IZQUIERDO: ANIMAL Y ANAMNESIS -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-blue-600">🐴 Información del Animal</h2>

                <!-- Animal (No editable) -->
                <div class="mb-6 p-4 bg-gray-100 rounded-lg">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        Animal
                    </label>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $historial->animal->nombre ?? 'N/A' }} ({{ $historial->animal->especie ?? 'N/A' }})
                    </p>
                </div>

                <!-- Tipo de Evento -->
                <div class="mb-6">
                    <label for="tipo_evento" class="block text-sm font-bold text-gray-700 mb-2">
                        Tipo de Evento *
                    </label>
                    <select name="tipo_evento" id="tipo_evento" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tipo_evento') border-red-500 @enderror">
                        <option value="">-- Selecciona una opción --</option>
                        <option value="Consulta" @selected(old('tipo_evento', $historial->tipo_evento) == 'Consulta')>Consulta</option>
                        <option value="Seguimiento" @selected(old('tipo_evento', $historial->tipo_evento) == 'Seguimiento')>Seguimiento</option>
                        <option value="Urgencia" @selected(old('tipo_evento', $historial->tipo_evento) == 'Urgencia')>Urgencia</option>
                        <option value="Vacunación" @selected(old('tipo_evento', $historial->tipo_evento) == 'Vacunación')>Vacunación</option>
                        <option value="Desparasitación" @selected(old('tipo_evento', $historial->tipo_evento) == 'Desparasitación')>Desparasitación</option>
                    </select>
                    @error('tipo_evento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold mb-4 text-blue-600">📋 Anamnesis</h2>

                <!-- Motivo de Consulta -->
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-bold text-gray-700 mb-2">
                        Motivo de Consulta
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('descripcion') border-red-500 @enderror"
                              placeholder="Describe el motivo de la consulta">{{ old('descripcion', $historial->descripcion) }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alimentación -->
                <div class="mb-6">
                    <label for="alimentacion_dieta" class="block text-sm font-bold text-gray-700 mb-2">
                        Alimentación / Dieta
                    </label>
                    <textarea name="alimentacion_dieta" id="alimentacion_dieta" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alimentacion_dieta') border-red-500 @enderror"
                              placeholder="Describe la alimentación del animal">{{ old('alimentacion_dieta', $historial->alimentacion_dieta) }}</textarea>
                    @error('alimentacion_dieta')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Enfermedades Previas -->
                <div class="mb-6">
                    <label for="enfermedades_previas" class="block text-sm font-bold text-gray-700 mb-2">
                        Enfermedades Previas
                    </label>
                    <textarea name="enfermedades_previas" id="enfermedades_previas" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('enfermedades_previas') border-red-500 @enderror"
                              placeholder="Antecedentes de enfermedades">{{ old('enfermedades_previas', $historial->enfermedades_previas) }}</textarea>
                    @error('enfermedades_previas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cirugías Previas -->
                <div class="mb-6">
                    <label for="cirugias_previas" class="block text-sm font-bold text-gray-700 mb-2">
                        Cirugías Previas
                    </label>
                    <textarea name="cirugias_previas" id="cirugias_previas" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cirugias_previas') border-red-500 @enderror"
                              placeholder="Antecedentes quirúrgicos">{{ old('cirugias_previas', $historial->cirugias_previas) }}</textarea>
                    @error('cirugias_previas')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Partos -->
                <div class="mb-6">
                    <label for="numero_partos" class="block text-sm font-bold text-gray-700 mb-2">
                        Número de Partos
                    </label>
                    <input type="text" name="numero_partos" id="numero_partos" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('numero_partos') border-red-500 @enderror"
                           placeholder="Ej: 3" value="{{ old('numero_partos', $historial->numero_partos) }}">
                    @error('numero_partos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Esquema Vacunal -->
                <div class="mb-6">
                    <label for="esquema_vacunal" class="block text-sm font-bold text-gray-700 mb-2">
                        Esquema Vacunal
                    </label>
                    <textarea name="esquema_vacunal" id="esquema_vacunal" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('esquema_vacunal') border-red-500 @enderror"
                              placeholder="Aftosa, Brucelosis, Carbón, Clostridosis">{{ old('esquema_vacunal', $historial->esquema_vacunal) }}</textarea>
                    @error('esquema_vacunal')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Última Desparasitación -->
                <div class="mb-6">
                    <label for="ultima_desparasitacion" class="block text-sm font-bold text-gray-700 mb-2">
                        Última Desparasitación
                    </label>
                    <textarea name="ultima_desparasitacion" id="ultima_desparasitacion" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('ultima_desparasitacion') border-red-500 @enderror"
                              placeholder="Fecha y producto">{{ old('ultima_desparasitacion', $historial->ultima_desparasitacion) }}</textarea>
                    @error('ultima_desparasitacion')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tratamientos Recientes -->
                <div class="mb-6">
                    <label for="tratamientos_recientes" class="block text-sm font-bold text-gray-700 mb-2">
                        Tratamientos Recientes
                    </label>
                    <textarea name="tratamientos_recientes" id="tratamientos_recientes" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tratamientos_recientes') border-red-500 @enderror"
                              placeholder="Medicinas o tratamientos recientes">{{ old('tratamientos_recientes', $historial->tratamientos_recientes) }}</textarea>
                    @error('tratamientos_recientes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Convive con otros animales -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        ¿Convive con otros animales?
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="convive_otros_animales" value="1" 
                                   @checked(old('convive_otros_animales', $historial->convive_otros_animales))
                                   class="w-5 h-5 text-blue-600 rounded">
                            <span class="ml-2 text-gray-700">Sí</span>
                        </label>
                    </div>
                </div>

                <!-- Cuáles animales -->
                <div class="mb-6">
                    <label for="cuales_animales" class="block text-sm font-bold text-gray-700 mb-2">
                        ¿Cuáles?
                    </label>
                    <textarea name="cuales_animales" id="cuales_animales" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('cuales_animales') border-red-500 @enderror"
                              placeholder="Especifica qué animales">{{ old('cuales_animales', $historial->cuales_animales) }}</textarea>
                    @error('cuales_animales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- LADO DERECHO: EXAMEN FÍSICO Y PROFESIONAL -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-green-600">🔬 Examen Físico (Opcional)</h2>

                <!-- Temperatura -->
                <div class="mb-6">
                    <label for="temperatura" class="block text-sm font-bold text-gray-700 mb-2">
                        Temperatura (°C)
                    </label>
                    <input type="text" name="temperatura" id="temperatura" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('temperatura') border-red-500 @enderror"
                           placeholder="Ej: 38.5" value="{{ old('temperatura', $historial->temperatura) }}">
                    @error('temperatura')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frecuencia Cardíaca -->
                <div class="mb-6">
                    <label for="frecuencia_cardiaca" class="block text-sm font-bold text-gray-700 mb-2">
                        Frecuencia Cardíaca (lpm)
                    </label>
                    <input type="text" name="frecuencia_cardiaca" id="frecuencia_cardiaca" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('frecuencia_cardiaca') border-red-500 @enderror"
                           placeholder="Ej: 80" value="{{ old('frecuencia_cardiaca', $historial->frecuencia_cardiaca) }}">
                    @error('frecuencia_cardiaca')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frecuencia Respiratoria -->
                <div class="mb-6">
                    <label for="frecuencia_respiratoria" class="block text-sm font-bold text-gray-700 mb-2">
                        Frecuencia Respiratoria (rpm)
                    </label>
                    <input type="text" name="frecuencia_respiratoria" id="frecuencia_respiratoria" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('frecuencia_respiratoria') border-red-500 @enderror"
                           placeholder="Ej: 30" value="{{ old('frecuencia_respiratoria', $historial->frecuencia_respiratoria) }}">
                    @error('frecuencia_respiratoria')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Otros Hallazgos Físicos -->
                <div class="mb-6">
                    <label for="otros_hallazgos_fisicos" class="block text-sm font-bold text-gray-700 mb-2">
                        Otros Hallazgos Físicos
                    </label>
                    <textarea name="otros_hallazgos_fisicos" id="otros_hallazgos_fisicos" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('otros_hallazgos_fisicos') border-red-500 @enderror"
                              placeholder="Observaciones del examen físico">{{ old('otros_hallazgos_fisicos', $historial->otros_hallazgos_fisicos) }}</textarea>
                    @error('otros_hallazgos_fisicos')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold mb-4 text-red-600">👨‍⚕️ Evaluación Profesional</h2>

                <!-- Diagnóstico (Obligatorio) -->
                <div class="mb-6">
                    <label for="diagnostico" class="block text-sm font-bold text-gray-700 mb-2">
                        Diagnóstico *
                    </label>
                    <textarea name="diagnostico" id="diagnostico" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('diagnostico') border-red-500 @enderror"
                              placeholder="Describe el diagnóstico del animal">{{ old('diagnostico', $historial->diagnostico) }}</textarea>
                    @error('diagnostico')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tratamiento (Obligatorio) -->
                <div class="mb-6">
                    <label for="tratamiento" class="block text-sm font-bold text-gray-700 mb-2">
                        Tratamiento Recomendado *
                    </label>
                    <textarea name="tratamiento" id="tratamiento" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 @error('tratamiento') border-red-500 @enderror"
                              placeholder="Especifica el tratamiento recomendado">{{ old('tratamiento', $historial->tratamiento) }}</textarea>
                    @error('tratamiento')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Observaciones -->
                <div class="mb-6">
                    <label for="observaciones" class="block text-sm font-bold text-gray-700 mb-2">
                        Observaciones
                    </label>
                    <textarea name="observaciones" id="observaciones" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('observaciones') border-red-500 @enderror"
                              placeholder="Notas adicionales">{{ old('observaciones', $historial->observaciones) }}</textarea>
                    @error('observaciones')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recomendaciones Finales -->
                <div class="mb-6">
                    <label for="recomendaciones_finales" class="block text-sm font-bold text-gray-700 mb-2">
                        Recomendaciones Finales
                    </label>
                    <textarea name="recomendaciones_finales" id="recomendaciones_finales" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('recomendaciones_finales') border-red-500 @enderror"
                              placeholder="Recomendaciones para el productor">{{ old('recomendaciones_finales', $historial->recomendaciones_finales) }}</textarea>
                    @error('recomendaciones_finales')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botones -->
                <div class="flex gap-3 mt-8 flex-wrap">
                    <button type="submit" class="flex-1 min-w-[150px] bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition">
                        ✅ Guardar Cambios
                    </button>
                    <a href="{{ route('historial.index') }}" class="flex-1 min-w-[150px] bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                        ❌ Cancelar
                    </a>
                    <button type="button" class="flex-1 min-w-[150px] bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-4 rounded-lg transition" 
                        onclick="confirmarEliminar({{ $historial->id_historial }})">
                        🗑️ Eliminar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Formulario oculto para eliminar -->
    <form id="deleteForm-{{ $historial->id_historial }}" action="{{ route('historial.destroy', $historial->id_historial) }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este historial? Esta acción no se puede deshacer.')) {
                document.getElementById('deleteForm-' + id).submit();
            }
        }
    </script>
</div>
@endsection