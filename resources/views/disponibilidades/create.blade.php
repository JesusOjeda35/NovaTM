@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-8 text-blue-600">📅 CREAR DISPONIBILIDAD PROFESIONAL</h1>

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('disponibilidades.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- COLUMNA IZQUIERDA: CALENDARIO -->
                <div class="border-r pr-8">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">📍 Selecciona un Día</h2>

                    <!-- Fecha específica -->
                    <div class="mb-6">
                        <label for="fecha" class="block text-sm font-bold text-gray-700 mb-3">
                            📅 Fecha Específica
                        </label>
                        <input 
                            type="date" 
                            name="fecha" 
                            id="fecha"
                            value="{{ old('fecha') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('fecha') border-red-500 @enderror"
                            required
                        >
                        @error('fecha')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Día de la semana (se calcula automáticamente) -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Día de la Semana</label>
                        <select 
                            name="dia_semana" 
                            id="dia_semana"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dia_semana') border-red-500 @enderror"
                            required
                        >
                            <option value="">Selecciona un día</option>
                            <option value="Lunes" @selected(old('dia_semana') == 'Lunes')>Lunes</option>
                            <option value="Martes" @selected(old('dia_semana') == 'Martes')>Martes</option>
                            <option value="Miércoles" @selected(old('dia_semana') == 'Miércoles')>Miércoles</option>
                            <option value="Jueves" @selected(old('dia_semana') == 'Jueves')>Jueves</option>
                            <option value="Viernes" @selected(old('dia_semana') == 'Viernes')>Viernes</option>
                            <option value="Sábado" @selected(old('dia_semana') == 'Sábado')>Sábado</option>
                            <option value="Domingo" @selected(old('dia_semana') == 'Domingo')>Domingo</option>
                        </select>
                        @error('dia_semana')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- COLUMNA DERECHA: HORAS Y DETALLES -->
                <div class="pl-8">
                    <h2 class="text-xl font-bold mb-6 text-gray-800">⏰ Selecciona Horario</h2>

                    <!-- Especialidad -->
                    <div class="mb-6">
                        <label for="especialidad" class="block text-sm font-bold text-gray-700 mb-2">
                            🏥 Especialidad
                        </label>
                        <input 
                            type="text" 
                            name="especialidad" 
                            id="especialidad"
                            value="{{ old('especialidad') }}"
                            placeholder="Ej: Cardiología, Dermatología, General"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('especialidad') border-red-500 @enderror"
                            required
                        >
                        @error('especialidad')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hora Inicio -->
                    <div class="mb-6">
                        <label for="hora_inicio" class="block text-sm font-bold text-gray-700 mb-2">
                            🕐 Hora de Inicio
                        </label>
                        <input 
                            type="time" 
                            name="hora_inicio" 
                            id="hora_inicio"
                            value="{{ old('hora_inicio') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hora_inicio') border-red-500 @enderror"
                            required
                        >
                        @error('hora_inicio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hora Fin -->
                    <div class="mb-6">
                        <label for="hora_fin" class="block text-sm font-bold text-gray-700 mb-2">
                            🕐 Hora de Fin
                        </label>
                        <input 
                            type="time" 
                            name="hora_fin" 
                            id="hora_fin"
                            value="{{ old('hora_fin') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('hora_fin') border-red-500 @enderror"
                            required
                        >
                        @error('hora_fin')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Precio -->
                    <div class="mb-6">
                        <label for="precio_consulta" class="block text-sm font-bold text-gray-700 mb-2">
                            💰 Precio de la Consulta
                        </label>
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-600 mr-2">$</span>
                            <input 
                                type="number" 
                                name="precio_consulta" 
                                id="precio_consulta"
                                step="0.01"
                                min="0"
                                value="{{ old('precio_consulta') }}"
                                placeholder="0.00"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('precio_consulta') border-red-500 @enderror"
                                required
                            >
                        </div>
                        @error('precio_consulta')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preview de horario seleccionado -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-sm font-bold text-blue-900 mb-2">📋 Resumen:</p>
                        <p class="text-sm text-blue-800">
                            <strong>📅 Fecha:</strong> <span id="preview_fecha">-</span>
                        </p>
                        <p class="text-sm text-blue-800">
                            <strong>📍 Día:</strong> <span id="preview_dia_text">-</span>
                        </p>
                        <p class="text-sm text-blue-800">
                            <strong>⏰ Horario:</strong> <span id="preview_hora">-</span>
                        </p>
                        <p class="text-sm text-blue-800">
                            <strong>💰 Precio:</strong> $<span id="preview_precio">0.00</span>
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-4">
                        <button 
                            type="submit" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition"
                        >
                            ✅ Confirmar Disponibilidad
                        </button>
                        <a 
                            href="{{ route('disponibilidades.index') }}" 
                            class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-lg text-center transition"
                        >
                            ❌ Cancelar
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    // Actualizar preview en tiempo real
    const fechaInput = document.getElementById('fecha');
    const diaSelect = document.getElementById('dia_semana');
    const horaInicio = document.getElementById('hora_inicio');
    const horaFin = document.getElementById('hora_fin');
    const precioInput = document.getElementById('precio_consulta');
    
    const previewFecha = document.getElementById('preview_fecha');
    const previewDiaText = document.getElementById('preview_dia_text');
    const previewHora = document.getElementById('preview_hora');
    const previewPrecio = document.getElementById('preview_precio');

    // Mapeo de días en español
    const diasSemana = {
        0: 'Domingo',
        1: 'Lunes',
        2: 'Martes',
        3: 'Miércoles',
        4: 'Jueves',
        5: 'Viernes',
        6: 'Sábado'
    };

    function actualizarPreview() {
        // Actualizar fecha
        if (fechaInput.value) {
            const fecha = new Date(fechaInput.value + 'T00:00:00');
            const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const fechaFormateada = fecha.toLocaleDateString('es-ES', opciones);
            previewFecha.textContent = fechaFormateada;

            // Calcular automáticamente el día de la semana
            const diaSemana = diasSemana[fecha.getDay()];
            diaSelect.value = diaSemana;
            previewDiaText.textContent = diaSemana;
        } else {
            previewFecha.textContent = '-';
            previewDiaText.textContent = diaSelect.value || '-';
        }
        
        const inicio = horaInicio.value || '--:--';
        const fin = horaFin.value || '--:--';
        previewHora.textContent = `${inicio} a ${fin}`;
        
        previewPrecio.textContent = (parseFloat(precioInput.value) || 0).toFixed(2);
    }

    fechaInput.addEventListener('change', actualizarPreview);
    diaSelect.addEventListener('change', actualizarPreview);
    horaInicio.addEventListener('change', actualizarPreview);
    horaFin.addEventListener('change', actualizarPreview);
    precioInput.addEventListener('input', actualizarPreview);

    // Inicializar preview
    actualizarPreview();
</script>

@endsection