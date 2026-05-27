@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- SECCIÓN 1: CITAS AGENDADAS POR EL USUARIO -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">📅 Mis Citas Agendadas</h2>

        @php
            $misConsultas = \App\Models\Consulta::where('user_id', auth()->user()->id)
                ->where('estado', 'agendada')
                ->with('animal', 'disponibilidad', 'User')
                ->latest('id_consulta')
                ->get();
        @endphp

        @if($misConsultas->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded">
                <p class="font-bold">No tienes citas agendadas aún</p>
                <p class="text-sm mt-2">Busca profesionales disponibles y agenda una consulta</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($misConsultas as $consulta)
                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Animal y Consulta -->
                            <div>
                                <h3 class="text-xl font-bold mb-4 text-gray-800">🐴 Tu Consulta</h3>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>Animal:</strong><br>
                                        {{ $consulta->animal->nombre ?? 'N/A' }} 
                                        <span class="text-gray-600">({{ $consulta->animal->especie ?? 'N/A' }})</span>
                                    </p>
                                    <p>
                                        <strong>Tipo:</strong><br>
                                        {{ $consulta->tipo_consulta }}
                                    </p>
                                    <p>
                                        <strong>Motivo:</strong><br>
                                        <span class="text-gray-700">{{ $consulta->motivo ?? 'No especificado' }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Profesional -->
                            <div>
                                <h3 class="text-xl font-bold mb-4 text-gray-800">👨‍⚕️ Profesional</h3>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm border border-gray-200">
                                    <p>
                                        <strong>Nombre:</strong><br>
                                        {{ $consulta->disponibilidad->user->nombre_completo ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>Email:</strong><br>
                                        <a href="mailto:{{ $consulta->disponibilidad->user->email }}" class="text-blue-600 hover:underline">
                                            {{ $consulta->disponibilidad->user->email ?? 'N/A' }}
                                        </a>
                                    </p>
                                    <p>
                                        <strong>Teléfono:</strong><br>
                                        <a href="tel:{{ $consulta->disponibilidad->user->telefono }}" class="text-blue-600 hover:underline">
                                            {{ $consulta->disponibilidad->user->telefono ?? 'N/A' }}
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <!-- Detalles de la Cita -->
                            <div>
                                <h3 class="text-xl font-bold mb-4 text-gray-800">📋 Detalles de la Cita</h3>
                                <div class="bg-yellow-50 p-4 rounded-lg space-y-2 text-sm border border-yellow-200">
                                    <p>
                                        <strong>📅 Fecha:</strong><br>
                                        @if($consulta->disponibilidad->fecha)
                                            {{ $consulta->disponibilidad->fecha->format('d/m/Y') }}
                                        @else
                                            Recurrente
                                        @endif
                                    </p>
                                    <p>
                                        <strong>📍 Día:</strong><br>
                                        {{ $consulta->disponibilidad->dia_semana }}
                                    </p>
                                    <p>
                                        <strong>🕐 Horario:</strong><br>
                                        {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_inicio)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_fin)->format('H:i') }}
                                    </p>
                                    <p>
                                        <strong>💰 Precio:</strong><br>
                                        ${{ number_format($consulta->disponibilidad->precio_consulta, 2) }}
                                    </p>
                                    <p>
                                        <strong>Estado:</strong><br>
                                        <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-bold">
                                            ✓ Agendada
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="mt-6 pt-6 border-t flex gap-2">
                            <a href="{{ route('consulta.show', $consulta->id_consulta) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Ver Detalles Completos
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- SECCIÓN 2: DISPONIBILIDADES DISPONIBLES PARA AGENDAR -->
    <div>
        <h2 class="text-3xl font-bold mb-6">🔍 Disponibilidades de Profesionales</h2>

        @if($disponibilidades->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded">
                <p class="font-bold">No hay disponibilidades activas en este momento</p>
            </div>
        @else
            <div class="space-y-8">
                @php
                    $profesionalesPrevios = null;
                @endphp

                @foreach($disponibilidades as $disp)
                    @if($profesionalesPrevios !== $disp->user_id)
                        @if($profesionalesPrevios !== null)
                            </div>
                        @endif
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <div class="mb-6 pb-6 border-b">
                                <h3 class="text-2xl font-bold text-gray-800">{{ $disp->user->nombre_completo }}</h3>
                                <p class="text-gray-600">{{ $disp->user->especialidad ?? 'Especialista' }}</p>
                                <p class="text-sm text-green-600 font-bold">🟢 En línea</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @php
                            $profesionalesPrevios = $disp->user_id;
                        @endphp
                    @endif

                    <!-- Tarjeta de disponibilidad -->
                    <div class="border rounded-lg p-4 hover:shadow-md transition bg-gray-50">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                ✓ Disponible
                            </span>
                        </div>

                        <div class="space-y-2 mb-4 text-sm">
                            <p>
                                <strong>📅 Fecha:</strong><br>
                                @if($disp->fecha)
                                    {{ $disp->fecha->format('d/m/Y') }}
                                @else
                                    Recurrente
                                @endif
                            </p>
                            <p>
                                <strong>📍 Día:</strong><br>
                                {{ $disp->dia_semana }}
                            </p>
                            <p>
                                <strong>🕐 Horario:</strong><br>
                                {{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($disp->hora_fin)->format('H:i') }}
                            </p>
                            <p>
                                <strong>🏥 Especialidad:</strong><br>
                                {{ $disp->especialidad }}
                            </p>
                            <p>
                                <strong>💰 Precio:</strong><br>
                                ${{ number_format($disp->precio_consulta, 2) }}
                            </p>
                        </div>

                        <a href="{{ route('consulta.create', ['disponibilidad_id' => $disp->id]) }}" 
                           class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2 px-4 rounded text-center transition block">
                            📅 Agendar
                        </a>
                    </div>

                    @if($loop->last || $disponibilidades[$loop->index + 1]->user_id !== $disp->user_id)
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection