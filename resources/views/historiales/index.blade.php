@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">📋 Historial Médico</h1>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('info'))
        <div class="mb-6 p-4 bg-blue-100 border-l-4 border-blue-600 text-blue-800 rounded">
            <i class="fas fa-info-circle"></i> {{ session('info') }}
        </div>
    @endif

    <!-- SECCIÓN 1: HISTORIALES CREADOS (para todos) -->
    <div class="mb-12">
        @if(auth()->user()->isProfesional())
            <h2 class="text-3xl font-bold mb-6 text-blue-600">✅ Historiales Creados</h2>
        @else
            <h2 class="text-3xl font-bold mb-6 text-blue-600">📋 Historiales de Mis Animales</h2>
        @endif

        @if($historiales->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded">
                <p class="font-bold">No hay historiales médicos</p>
                <p class="text-sm mt-2">
                    @if(auth()->user()->isProfesional())
                        Crea tu primer historial clínico
                    @else
                        Los historiales de tus animales aparecerán aquí
                    @endif
                </p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($historiales as $historial)
                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <!-- Animal -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">🐴 Animal</h3>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>Nombre:</strong><br>
                                        {{ $historial->animal->nombre ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>Especie:</strong><br>
                                        {{ $historial->animal->especie ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>Raza:</strong><br>
                                        {{ $historial->animal->raza ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Profesional -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">👨‍⚕️ Profesional</h3>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>Nombre:</strong><br>
                                        {{ $historial->User->nombre_completo ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>Especialidad:</strong><br>
                                        {{ $historial->User->especialidad ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Evento -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">📌 Evento</h3>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>Tipo:</strong><br>
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">
                                            {{ $historial->tipo_evento }}
                                        </span>
                                    </p>
                                    <p>
                                        <strong>Fecha:</strong><br>
                                        {{ $historial->fecha->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Diagnóstico -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">🔍 Diagnóstico</h3>
                                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200 h-full">
                                    <p class="text-sm text-gray-700">
                                        {{ Str::limit($historial->diagnostico, 100) ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="mt-6 pt-6 border-t flex gap-2 flex-wrap">
                            <a href="{{ route('historial.show', $historial->id_historial) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                👁️ Ver Completo
                            </a>
                            
                            {{-- SOLO LOS PROFESIONALES VEN ESTOS BOTONES --}}
                            @if(auth()->user()->isProfesional() && $historial->user_id === auth()->id())
                                <a href="{{ route('historial.edit', $historial->id_historial) }}" 
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('historial.destroy', $historial->id_historial) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm(`¿Estás seguro de que deseas eliminar este historial?\n\nAnimal: {{ $historial->animal->nombre }}\nFecha: {{ $historial->fecha->format('d/m/Y H:i') }}\n\nEsta acción no se puede deshacer.`);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($historiales->hasPages())
                <div class="mt-8">
                    {{ $historiales->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- SECCIÓN 2: CITAS SIN HISTORIAL (solo para profesionales) -->
    @if(auth()->user()->isProfesional())
        @php
            $consultasSinHistorial = \App\Models\Consulta::where('user_id', auth()->user()->id)
                ->where('estado', 'agendada')
                ->whereNull('historial_id')
                ->with('animal', 'User', 'disponibilidad')
                ->get();
        @endphp

        @if($consultasSinHistorial->count() > 0)
            <div>
                <h2 class="text-3xl font-bold mb-6 text-orange-600">⚠️ Citas Agendadas sin Historial</h2>
                <p class="text-gray-600 mb-4">Estas citas aún no tienen historial clínico. Haz clic en "Crear Historial" para completarlas.</p>

                <div class="grid gap-6">
                    @foreach($consultasSinHistorial as $consulta)
                        <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-orange-500 hover:shadow-xl transition">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <!-- Animal -->
                                <div>
                                    <h3 class="text-lg font-bold mb-3 text-gray-800">🐴 Animal</h3>
                                    <div class="space-y-2 text-sm">
                                        <p>
                                            <strong>Nombre:</strong><br>
                                            {{ $consulta->animal->nombre ?? 'N/A' }}
                                        </p>
                                        <p>
                                            <strong>Especie:</strong><br>
                                            {{ $consulta->animal->especie ?? 'N/A' }}
                                        </p>
                                        <p>
                                            <strong>Raza:</strong><br>
                                            {{ $consulta->animal->raza ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Productor -->
                                <div>
                                    <h3 class="text-lg font-bold mb-3 text-gray-800">👤 Productor</h3>
                                    <div class="space-y-2 text-sm">
                                        <p>
                                            <strong>Nombre:</strong><br>
                                            {{ $consulta->User->nombre_completo ?? 'N/A' }}
                                        </p>
                                        <p>
                                            <strong>Email:</strong><br>
                                            <a href="mailto:{{ $consulta->User->email }}" class="text-blue-600 hover:underline">
                                                {{ $consulta->User->email ?? 'N/A' }}
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <!-- Cita -->
                                <div>
                                    <h3 class="text-lg font-bold mb-3 text-gray-800">📅 Cita</h3>
                                    <div class="space-y-2 text-sm">
                                        <p>
                                            <strong>Tipo:</strong><br>
                                            {{ $consulta->tipo_consulta }}
                                        </p>
                                        <p>
                                            <strong>Motivo:</strong><br>
                                            {{ Str::limit($consulta->motivo, 50) ?? 'N/A' }}
                                        </p>
                                        @if($consulta->disponibilidad)
                                            <p>
                                                <strong>Hora:</strong><br>
                                                {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_inicio)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_fin)->format('H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Urgencia -->
                                <div>
                                    <h3 class="text-lg font-bold mb-3 text-gray-800">⚠️ Urgencia</h3>
                                    <div class="space-y-2 text-sm">
                                        <p>
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                                                @if($consulta->urgencia === 'Crítico') bg-red-100 text-red-800
                                                @elseif($consulta->urgencia === 'Alto') bg-orange-100 text-orange-800
                                                @elseif($consulta->urgencia === 'Medio') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ $consulta->urgencia ?? 'No especificada' }}
                                            </span>
                                        </p>
                                        <p class="pt-2">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                                ❌ Sin Historial
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="mt-6 pt-6 border-t flex gap-2 flex-wrap">
                                <a href="{{ route('consulta.show', $consulta->id_consulta) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                    👁️ Ver Detalles
                                </a>
                                <a href="{{ route('historial.create', ['consulta_id' => $consulta->id_consulta]) }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                    ➕ Crear Historial
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection