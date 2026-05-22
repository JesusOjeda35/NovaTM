@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <!-- HEADER CON BÚSQUEDA -->
    <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-gray-800 rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-3xl font-bold mb-6">¿Qué especialidad estás buscando?</h2>
        
        <form action="{{ route('profesionales.buscar') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Filtro de especialidad -->
            <div>
                <label for="especialidad" class="block text-sm font-semibold mb-2 text-gray-700">Especialidad</label>
                <input type="text" name="especialidad" id="especialidad" value="{{ request('especialidad') }}"
                    placeholder="Buscar especialidad..."
                    class="w-full px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 border border-gray-300">
            </div>

            <!-- Filtro de día -->
            <div>
                <label for="dia_semana" class="block text-sm font-semibold mb-2 text-gray-700">Día de la Semana</label>
                <select name="dia_semana" id="dia_semana" class="w-full px-4 py-3 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800 border border-gray-300">
                    <option value="">Todos los días</option>
                    <option value="Lunes" {{ request('dia_semana') === 'Lunes' ? 'selected' : '' }}>Lunes</option>
                    <option value="Martes" {{ request('dia_semana') === 'Martes' ? 'selected' : '' }}>Martes</option>
                    <option value="Miércoles" {{ request('dia_semana') === 'Miércoles' ? 'selected' : '' }}>Miércoles</option>
                    <option value="Jueves" {{ request('dia_semana') === 'Jueves' ? 'selected' : '' }}>Jueves</option>
                    <option value="Viernes" {{ request('dia_semana') === 'Viernes' ? 'selected' : '' }}>Viernes</option>
                    <option value="Sábado" {{ request('dia_semana') === 'Sábado' ? 'selected' : '' }}>Sábado</option>
                    <option value="Domingo" {{ request('dia_semana') === 'Domingo' ? 'selected' : '' }}>Domingo</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-4 rounded-lg transition">
                    <i class="fas fa-search"></i> Buscar
                </button>
            </div>
        </form>

        <!-- Botones de especialidades rápidas -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('profesionales.buscar', ['especialidad' => 'Odontología']) }}" class="px-4 py-2 bg-white text-yellow-600 rounded-full font-semibold hover:bg-gray-100 transition text-sm">Odontología</a>
            <a href="{{ route('profesionales.buscar', ['especialidad' => 'Cirugía']) }}" class="px-4 py-2 bg-white text-yellow-600 rounded-full font-semibold hover:bg-gray-100 transition text-sm">Cirugía</a>
            <a href="{{ route('profesionales.buscar', ['especialidad' => 'Oftalmología']) }}" class="px-4 py-2 bg-white text-yellow-600 rounded-full font-semibold hover:bg-gray-100 transition text-sm">Oftalmología</a>
            <a href="{{ route('profesionales.buscar', ['especialidad' => 'Pediatría']) }}" class="px-4 py-2 bg-white text-yellow-600 rounded-full font-semibold hover:bg-gray-100 transition text-sm">Pediatría</a>
            <a href="{{ route('profesionales.buscar', ['especialidad' => 'Medicina general']) }}" class="px-4 py-2 bg-white text-yellow-600 rounded-full font-semibold hover:bg-gray-100 transition text-sm">Medicina general</a>
        </div>
    </div>

    <!-- RESULTADOS -->
    @if ($disponibilidades->count() > 0)
        <div class="space-y-6">
            @php
                $profesionalesPorUsuario = $disponibilidades->groupBy('user_id');
            @endphp

            @foreach ($profesionalesPorUsuario as $usuarioId => $disponiblidadesPorUsuario)
                @php
                    $profesional = $disponiblidadesPorUsuario->first()->user;
                @endphp

                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
                        <!-- Información del profesional -->
                        <div class="md:col-span-1 text-center border-r border-gray-200">
                            <div class="w-24 h-24 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-full flex items-center justify-center text-white text-4xl font-bold mb-4 mx-auto">
                                {{ strtoupper(substr($profesional->nombre_completo, 0, 1)) }}
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $profesional->nombre_completo }}</h3>
                            <p class="text-yellow-600 font-semibold text-sm mb-2">{{ $profesional->especialidad ?? 'Profesional' }}</p>
                            <div class="flex items-center justify-center mb-3">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star text-yellow-400"></i>
                                @endfor
                            </div>
                            <p class="text-gray-600 text-xs">5.0 (332 opiniones)</p>
                        </div>

                        <!-- Disponibilidades por hora -->
                        <div class="md:col-span-3">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                @php
                                    $diasSemana = ['Sunday' => 'Domingo', 'Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles', 'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado'];
                                    $diasMostrados = [
                                        ['hoy' => 'Hoy', 'fecha' => now()->format('d M'), 'dia' => $diasSemana[now()->format('l')], 'carbon' => now()],
                                        ['hoy' => 'Mañana', 'fecha' => now()->addDay()->format('d M'), 'dia' => $diasSemana[now()->addDay()->format('l')], 'carbon' => now()->addDay()],
                                        ['hoy' => '', 'fecha' => now()->addDays(2)->format('d M'), 'dia' => $diasSemana[now()->addDays(2)->format('l')], 'carbon' => now()->addDays(2)],
                                        ['hoy' => '', 'fecha' => now()->addDays(3)->format('d M'), 'dia' => $diasSemana[now()->addDays(3)->format('l')], 'carbon' => now()->addDays(3)],
                                    ];
                                @endphp

                                @foreach ($diasMostrados as $diaInfo)
                                    <div class="border border-gray-200 rounded-lg p-3 text-center">
                                        <p class="text-center font-semibold text-gray-700 text-sm mb-1">{{ $diaInfo['hoy'] }}</p>
                                        <p class="text-center text-xs text-gray-600 mb-3">{{ $diaInfo['fecha'] }}</p>

                                        @php
                                            $disponibilidadesDelDia = $disponiblidadesPorUsuario->where('dia_semana', $diaInfo['dia']);
                                        @endphp

                                        @if ($disponibilidadesDelDia->count() > 0)
                                            <div class="space-y-2">
                                                @foreach ($disponibilidadesDelDia as $disp)
                                                    <button class="w-full bg-yellow-100 hover:bg-yellow-200 text-yellow-700 font-bold py-2 px-2 rounded text-xs transition"
                                                        onclick="agendarConsulta({{ $disp->id }}, '{{ $profesional->nombre_completo }}', '{{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }}', {{ $disp->precio_consulta }})">
                                                        {{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center text-gray-400 text-xs">No disponible</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Información del profesional -->
                            <div class="border-t border-gray-200 pt-4">
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-map-marker-alt text-yellow-600"></i> <strong>Dirección:</strong> {{ $profesional->direccion ?? 'En línea' }}
                                </p>
                                <p class="text-sm text-gray-600 mb-2">
                                    <i class="fas fa-dollar-sign text-green-600"></i> <strong>Precio:</strong> ${{ number_format($disponiblidadesPorUsuario->first()->precio_consulta, 2) }}
                                </p>
                                <p class="text-sm text-yellow-600 font-semibold">
                                    <i class="fas fa-video text-yellow-600"></i> En línea
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-blue-50 border-l-4 border-blue-500 p-8 rounded-lg text-center">
            <i class="fas fa-search text-4xl text-blue-500 mb-4 block"></i>
            <p class="text-gray-600 text-lg">No encontramos profesionales disponibles con esos criterios.</p>
            <p class="text-gray-500 text-sm mt-2">Intenta con otra especialidad o día.</p>
        </div>
    @endif
</div>

<script>
function agendar Consulta(disponibilidadId, nombreProfesional, hora, precio) {
    // Mostrar modal o redirigir a formulario de agendamiento
    console.log(`Agendando con ${nombreProfesional} a las ${hora} -
