@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Mis Disponibilidades para Consultas</h1>
        <a href="{{ route('disponibilidades.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
            <i class="fas fa-plus"></i> Agregar Disponibilidad
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($disponibilidades->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($disponibilidades as $disp)
                <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-400 hover:shadow-lg transition">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $disp->especialidad }}</h3>
                            <p class="text-yellow-600 font-semibold"><i class="fas fa-calendar"></i> {{ $disp->dia_semana }}</p>
                            @if($disp->fecha)
                                <p class="text-sm text-gray-600">{{ $disp->fecha->format('d/m/Y') }}</p>
                            @endif
                        </div>
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $disp->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $disp->activo ? '✓ Activo' : '✕ Inactivo' }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-gray-700 mb-2">
                            <i class="fas fa-clock text-yellow-600"></i> <strong>Horario:</strong> 
                            {{ \Carbon\Carbon::parse($disp->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($disp->hora_fin)->format('H:i') }}
                        </p>
                        <p class="text-gray-700">
                            <i class="fas fa-dollar-sign text-green-600"></i> <strong>Precio:</strong> 
                            ${{ number_format($disp->precio_consulta, 2) }}
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('disponibilidades.edit', $disp->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded text-center transition">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('disponibilidades.destroy', $disp->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition" onclick="return confirm('¿Estás seguro?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
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
@endsection