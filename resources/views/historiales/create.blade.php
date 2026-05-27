@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">📝 Crear Historial Clínico</h1>

    <form method="POST" action="{{ route('historial.store') }}" class="bg-white rounded-lg shadow-lg p-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- LADO IZQUIERDO: ANIMAL Y ANAMNESIS -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-blue-600">🐴 Información del Animal</h2>

                <!-- Animal -->
                <div class="mb-6">
                    <label for="animales_id_animal" class="block text-sm font-bold text-gray-700 mb-2">
                        Animal *
                    </label>
                    <select name="animales_id_animal" id="animales_id_animal" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona un animal</option>
                        @if($animal)
                            <option value="{{ $animal->id_animal }}" selected>
                                {{ $animal->nombre }} ({{ $animal->especie }})
                            </option>
                        @else
                            @foreach(\App\Models\Animal::where('user_id', auth()->user()->id)->get() as $anim)
                                <option value="{{ $anim->id_animal }}">
                                    {{ $anim->nombre }} ({{ $anim->especie }})
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <!-- Tipo de Evento -->
                <div class="mb-6">
                    <label for="tipo_evento" class="block text-sm font-bold text-gray-700 mb-2">
                        Tipo de Evento *
                    </label>
                    <select name="tipo_evento" id="tipo_evento" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Selecciona tipo</option>
                        <option value="Consulta">Consulta</option>
                        <option value="Seguimiento">Seguimiento</option>
                        <option value="Urgencia">Urgencia</option>
                        <option value="Vacunación">Vacunación</option>
                        <option value="Desparasitación">Desparasitación</option>
                    </select>
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold mb-4 text-blue-600">📋 Anamnesis</h2>

                <!-- Motivo de Consulta -->
                <div class="mb-6">
                    <label for="descripcion" class="block text-sm font-bold text-gray-700 mb-2">
                        Motivo de Consulta
                    </label>
                    <textarea name="descripcion" id="descripcion" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe el motivo de la consulta"></textarea>
                </div>

                <!-- Alimentación -->
                <div class="mb-6">
                    <label for="alimentacion_dieta" class="block text-sm font-bold text-gray-700 mb-2">
                        Alimentación / Dieta
                    </label>
                    <textarea name="alimentacion_dieta" id="alimentacion_dieta" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Describe la alimentación del animal"></textarea>
                </div>

                <!-- Enfermedades Previas -->
                <div class="mb-6">
                    <label for="enfermedades_previas" class="block text-sm font-bold text-gray-700 mb-2">
                        Enfermedades Previas
                    </label>
                    <textarea name="enfermedades_previas" id="enfermedades_previas" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Antecedentes de enfermedades"></textarea>
                </div>

                <!-- Cirugías Previas -->
                <div class="mb-6">
                    <label for="cirugias_previas" class="block text-sm font-bold text-gray-700 mb-2">
                        Cirugías Previas
                    </label>
                    <textarea name="cirugias_previas" id="cirugias_previas" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Antecedentes quirúrgicos"></textarea>
                </div>

                <!-- Número de Partos -->
                <div class="mb-6">
                    <label for="numero_partos" class="block text-sm font-bold text-gray-700 mb-2">
                        Número de Partos
                    </label>
                    <input type="text" name="numero_partos" id="numero_partos" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: 3">
                </div>

                <!-- Esquema Vacunal -->
                <div class="mb-6">
                    <label for="esquema_vacunal" class="block text-sm font-bold text-gray-700 mb-2">
                        Esquema Vacunal
                    </label>
                    <textarea name="esquema_vacunal" id="esquema_vacunal" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Aftosa, Brucelosis, Carbón, Clostridosis"></textarea>
                </div>

                <!-- Última Desparasitación -->
                <div class="mb-6">
                    <label for="ultima_desparasitacion" class="block text-sm font-bold text-gray-700 mb-2">
                        Última Desparasitación
                    </label>
                    <textarea name="ultima_desparasitacion" id="ultima_desparasitacion" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Fecha y producto"></textarea>
                </div>

                <!-- Tratamientos Recientes -->
                <div class="mb-6">
                    <label for="tratamientos_recientes" class="block text-sm font-bold text-gray-700 mb-2">
                        Tratamientos Recientes
                    </label>
                    <textarea name="tratamientos_recientes" id="tratamientos_recientes" rows="2" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Medicinas o tratamientos recientes"></textarea>
                </div>

                <!-- Convive con otros animales -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        ¿Convive con otros animales?
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="convive_otros_animales" value="1" 
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
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Especifica qué animales"></textarea>
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
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: 38.5">
                </div>

                <!-- Frecuencia Cardíaca -->
                <div class="mb-6">
                    <label for="frecuencia_cardiaca" class="block text-sm font-bold text-gray-700 mb-2">
                        Frecuencia Cardíaca (lpm)
                    </label>
                    <input type="text" name="frecuencia_cardiaca" id="frecuencia_cardiaca" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: 80">
                </div>

                <!-- Frecuencia Respiratoria -->
                <div class="mb-6">
                    <label for="frecuencia_respiratoria" class="block text-sm font-bold text-gray-700 mb-2">
                        Frecuencia Respiratoria (rpm)
                    </label>
                    <input type="text" name="frecuencia_respiratoria" id="frecuencia_respiratoria" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: 30">
                </div>

                <!-- Otros Hallazgos Físicos -->
                <div class="mb-6">
                    <label for="otros_hallazgos_fisicos" class="block text-sm font-bold text-gray-700 mb-2">
                        Otros Hallazgos Físicos
                    </label>
                    <textarea name="otros_hallazgos_fisicos" id="otros_hallazgos_fisicos" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Observaciones del examen físico"></textarea>
                </div>

                <hr class="my-6">

                <h2 class="text-2xl font-bold mb-4 text-red-600">👨‍⚕️ Evaluación Profesional</h2>

                <!-- Diagnóstico (Obligatorio) -->
                <div class="mb-6">
                    <label for="diagnostico" class="block text-sm font-bold text-gray-700 mb-2">
                        Diagnóstico *
                    </label>
                    <textarea name="diagnostico" id="diagnostico" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Describe el diagnóstico del animal"></textarea>
                </div>

                <!-- Tratamiento (Obligatorio) -->
                <div class="mb-6">
                    <label for="tratamiento" class="block text-sm font-bold text-gray-700 mb-2">
                        Tratamiento Recomendado *
                    </label>
                    <textarea name="tratamiento" id="tratamiento" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                              placeholder="Especifica el tratamiento recomendado"></textarea>
                </div>

                <!-- Observaciones -->
                <div class="mb-6">
                    <label for="observaciones" class="block text-sm font-bold text-gray-700 mb-2">
                        Observaciones
                    </label>
                    <textarea name="observaciones" id="observaciones" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Notas adicionales"></textarea>
                </div>

                <!-- Recomendaciones Finales -->
                <div class="mb-6">
                    <label for="recomendaciones_finales" class="block text-sm font-bold text-gray-700 mb-2">
                        Recomendaciones Finales
                    </label>
                    <textarea name="recomendaciones_finales" id="recomendaciones_finales" rows="3" 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Recomendaciones para el productor"></textarea>
                </div>

                  <!-- Botones -->
                <div class="flex gap-3 mt-8">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition">
                        ✅ Guardar Historial
                    </button>
                    <a href="{{ route('historial.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                        ❌ Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        // Permite que el formulario se envíe normalmente
        // El servidor se encargará de la redirección
    });
</script>

@endsection