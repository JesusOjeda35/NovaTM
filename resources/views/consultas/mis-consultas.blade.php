@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">📋 Mis Consultas</h1>

    @if($consultas->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-6 rounded">
            <p class="font-bold">No tienes consultas registradas</p>
            <p class="text-sm mt-2">
                <a href="{{ route('profesionales.buscar') }}" class="text-yellow-700 font-bold hover:underline">
                    → Buscar un profesional para agendar una consulta
                </a>
            </p>
        </div>
    @else
        <div class="grid gap-6">
            @foreach($consultas as $consulta)
                <div class="bg-white rounded-lg shadow-lg p-6 border-l-4 border-blue-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-2xl font-bold">{{ $consulta->animal->nombre ?? 'Animal' }}</h2>
                            <p class="text-gray-600">{{ $consulta->animal->especie ?? '' }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-bold 
                            @if($consulta->estado === 'pendiente') bg-yellow-100 text-yellow-800
                            @elseif($consulta->estado === 'atendida') bg-green-100 text-green-800
                            @elseif($consulta->estado === 'cancelada') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($consulta->estado) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600">Tipo</p>
                            <p class="font-bold">{{ $consulta->tipo_consulta }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Urgencia</p>
                            <p class="font-bold">{{ $consulta->urgencia ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha Solicitud</p>
                            <p class="font-bold">{{ $consulta->fecha_solicitud->format('d/m/Y H:i') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Fecha Atención</p>
                            <p class="font-bold">{{ $consulta->fecha_atencion?->format('d/m/Y H:i') ?? '-' }}</p>
                        </div>
                    </div>

                    @if($consulta->motivo)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600">Motivo</p>
                            <p class="text-gray-800">{{ $consulta->motivo }}</p>
                        </div>
                    @endif

                    <div class="flex gap-2">
                        <a href="{{ route('consulta.show', $consulta->id_consulta) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-8">
            {{ $consultas->links() }}
        </div>
    @endif
</div>
@endsection