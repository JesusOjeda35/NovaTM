@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Mi Panel - Profesional</h1>
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

    <!-- SECCIÓN 1: CITAS APARTADAS -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold mb-6">📅 Citas Apartadas por Productores</h2>

        @if($consultas->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded">
                <p class="font-bold">No tienes citas apartadas</p>
                <p class="text-sm mt-2">Los productores podrán agendar consultas basándose en tus disponibilidades.</p>
            </div>
        @else
            <div class="grid gap-6">
                @foreach($consultas as $consulta)
                    <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Información de la Consulta -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">📋 Información de la Consulta</h3>
                                <div class="space-y-2 text-sm">
                                    <p>
                                        <strong>🐴 Animal:</strong><br>
                                        {{ $consulta->animal->nombre ?? 'N/A' }} 
                                        <span class="text-gray-600">({{ $consulta->animal->especie ?? 'N/A' }})</span>
                                    </p>
                                    <p>
                                        <strong>📌 Tipo:</strong><br>
                                        {{ $consulta->tipo_consulta }}
                                    </p>
                                    <p>
                                        <strong>⚠️ Urgencia:</strong><br>
                                        <span class="px-2 py-1 rounded-full text-xs font-bold
                                            @if($consulta->urgencia === 'Crítico') bg-red-100 text-red-800
                                            @elseif($consulta->urgencia === 'Alto') bg-orange-100 text-orange-800
                                            @elseif($consulta->urgencia === 'Medio') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800
                                            @endif">
                                            {{ $consulta->urgencia ?? 'No especificada' }}
                                        </span>
                                    </p>
                                    <p>
                                        <strong>📝 Motivo:</strong><br>
                                        <span class="text-gray-700">{{ $consulta->motivo ?? 'Sin motivo especificado' }}</span>
                                    </p>
                                </div>
                            </div>

                            <!-- Información del Productor -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">👤 Información del Productor</h3>
                                <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm border border-gray-200">
                                    <p>
                                        <strong>📛 Nombre:</strong><br>
                                        {{ $consulta->User->nombre_completo ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>📧 Email:</strong><br>
                                        <a href="mailto:{{ $consulta->User->email }}" class="text-blue-600 hover:underline">
                                            {{ $consulta->User->email ?? 'N/A' }}
                                        </a>
                                    </p>
                                    <p>
                                        <strong>📱 Teléfono:</strong><br>
                                        <a href="tel:{{ $consulta->User->telefono }}" class="text-blue-600 hover:underline">
                                            {{ $consulta->User->telefono ?? 'N/A' }}
                                        </a>
                                    </p>
                                    <p>
                                        <strong>📍 Ubicación:</strong><br>
                                        {{ $consulta->User->ubicacion_formatted ?? 'N/A' }}
                                    </p>
                                    <p>
                                        <strong>🏢 Ganadería:</strong><br>
                                        {{ $consulta->User->nombre_ganaderia ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Detalles de la Cita Agendada -->
                            <div>
                                <h3 class="text-lg font-bold mb-3 text-gray-800">📅 Detalles de la Cita</h3>
                                <div class="bg-yellow-50 p-4 rounded-lg space-y-2 text-sm border border-yellow-200">
                                    <p>
                                        <strong>📅 Fecha:</strong><br>
                                        @if($consulta->disponibilidad && $consulta->disponibilidad->fecha)
                                            {{ $consulta->disponibilidad->fecha->format('d/m/Y') }}
                                        @else
                                            Recurrente
                                        @endif
                                    </p>
                                    <p>
                                        <strong>📍 Día:</strong><br>
                                        @if($consulta->disponibilidad)
                                            {{ $consulta->disponibilidad->dia_semana }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p>
                                        <strong>🕐 Horario:</strong><br>
                                        @if($consulta->disponibilidad)
                                            {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_inicio)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($consulta->disponibilidad->hora_fin)->format('H:i') }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p>
                                        <strong>💰 Precio:</strong><br>
                                        @if($consulta->disponibilidad)
                                            ${{ number_format($consulta->disponibilidad->precio_consulta, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                    <p>
                                        <strong>Estado:</strong><br>
                                        <span class="px-3 py-1 rounded-full text-xs font-bold
                                            @if($consulta->estado === 'agendada') bg-green-100 text-green-800
                                            @elseif($consulta->estado === 'atendida') bg-blue-100 text-blue-800
                                            @elseif($consulta->estado === 'cancelada') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($consulta->estado) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Acciones -->
                        <div class="mt-6 pt-6 border-t flex gap-2 flex-wrap">
                            <a href="{{ route('consulta.show', $consulta->id_consulta) }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                                Ver Detalles Completos
                            </a>
                            @if($consulta->estado === 'agendada')
                                <form action="{{ route('consulta.attend', $consulta->id_consulta) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                                        ✅ Atender Cita
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            @if($consultas->hasPages())
                <div class="mt-8">
                    {{ $consultas->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- SECCIÓN 2: MIS DISPONIBILIDADES -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Mis Disponibilidades para Consultas</h2>
            <a href="{{ route('disponibilidades.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                <i class="fas fa-plus"></i> Agregar Disponibilidad
            </a>
        </div>

        @if ($disponibilidades->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($disponibilidades as $disp)
                    @php
                        $consultasParaEstaDisponibilidad = $consultas->where('disponibilidad_id', $disp->id)->count();
                        $estaAgendada = $consultasParaEstaDisponibilidad > 0;
                    @endphp
                    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 {{ $estaAgendada ? 'border-purple-400' : 'border-yellow-400' }} hover:shadow-lg transition">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">{{ $disp->especialidad }}</h3>
                                <p class="text-yellow-600 font-semibold"><i class="fas fa-calendar"></i> {{ $disp->dia_semana }}</p>
                                @if($disp->fecha)
                                    <p class="text-sm text-gray-600">{{ $disp->fecha->format('d/m/Y') }}</p>
                                @endif
                            </div>
                            <div class="flex flex-col gap-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $disp->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-right">
                                    {{ $disp->activo ? '✓ Activo' : '✕ Inactivo' }}
                                </span>
                                @if($estaAgendada)
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800 text-right">
                                        📅 Agendada
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 text-right">
                                        ✓ Disponible
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4 mb-4 space-y-2 border border-gray-200">
                            <p class="text-gray-700">
                                <i class="fas fa-clock text-yellow-600"></i> <strong>Horario:</strong> 
                                <span class="text-yellow-600 font-semibold">{{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($disp->hora_fin)->format('H:i') }}</span>
                            </p>
                            <p class="text-gray-700">
                                <i class="fas fa-dollar-sign text-green-600"></i> <strong>Precio:</strong> 
                                <span class="text-green-600 font-semibold">${{ number_format($disp->precio_consulta, 2) }}</span>
                            </p>
                            <p class="text-gray-700 pt-2 border-t border-gray-300">
                                <i class="fas fa-users text-blue-600"></i> <strong>Citas Agendadas:</strong> 
                                <span class="font-bold {{ $estaAgendada ? 'text-purple-600' : 'text-gray-600' }}">{{ $consultasParaEstaDisponibilidad }}</span>
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('disponibilidades.edit', $disp->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center transition flex items-center justify-center gap-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <button 
                                type="button"
                                onclick="abrirModalEliminar('{{ $disp->id }}', '{{ $disp->especialidad }}')"
                                class="flex-1 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded text-center transition flex items-center justify-center gap-2">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>

                        @if($estaAgendada)
                            <div class="mt-4 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                                <p class="text-sm text-purple-800">
                                    <i class="fas fa-info-circle"></i> Esta disponibilidad ya tiene una cita agendada y no aparecerá en búsquedas de productores.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- Modal Eliminar -->
                    <div id="modal-eliminar-{{ $disp->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-2xl max-w-md w-full p-6 transform transition-all duration-300">
                            <div class="text-center mb-4">
                                <div class="inline-block p-3 bg-red-100 rounded-full mb-4">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">¿Eliminar disponibilidad?</h3>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                                <p class="text-gray-700 font-semibold text-center">{{ $disp->especialidad }}</p>
                                <p class="text-gray-600 text-center text-sm">{{ $disp->dia_semana }} - {{ $disp->fecha?->format('d/m/Y') }}</p>
                            </div>

                            <p class="text-gray-600 text-sm mb-6 text-center">
                                Esta acción no se puede deshacer. ¿Estás seguro de que deseas eliminar esta disponibilidad?
                            </p>

                            <div class="flex gap-3">
                                <button 
                                    type="button"
                                    onclick="cerrarModalEliminar('{{ $disp->id }}')"
                                    class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                                    Cancelar
                                </button>
                                <form action="{{ route('disponibilidades.destroy', $disp->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 p-6 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                <h3 class="text-lg font-bold text-blue-800 mb-2"><i class="fas fa-info-circle"></i> ¿Qué sucede ahora?</h3>
                <p class="text-blue-700">Los productores podrán ver estas disponibilidades cuando busquen profesionales y agendarán consultas. Una vez agendada, la disponibilidad desaparecerá del listado de búsqueda.</p>
            </div>
        @else
            <div class="bg-blue-50 border-l-4 border-blue-500 p-8 rounded-lg text-center">
                <i class="fas fa-calendar-times text-4xl text-blue-500 mb-4 block"></i>
                <p class="text-gray-600 mb-4 text-lg">No tienes disponibilidades creadas aún.</p>
                <p class="text-gray-500 mb-6">Crea tu primera disponibilidad para que los productores puedan verte y agendar consultas contigo.</p>
                <a href="{{ route('disponibilidades.create') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
                    <i class="fas fa-plus"></i> Crear Primera Disponibilidad
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Scripts para modales -->
<script>
function abrirModalEliminar(id, nombre) {
    const modal = document.getElementById(`modal-eliminar-${id}`);
    if (modal) {
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function cerrarModalEliminar(id) {
    const modal = document.getElementById(`modal-eliminar-${id}`);
    if (modal) {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

document.addEventListener('click', function(event) {
    const modales = document.querySelectorAll('[id^="modal-eliminar-"]');
    modales.forEach(modal => {
        if (event.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modales = document.querySelectorAll('[id^="modal-eliminar-"]:not(.hidden)');
        modales.forEach(modal => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }
});
</script>

@endsection