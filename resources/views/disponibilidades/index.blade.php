@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Mis Disponibilidades</h1>
        <a href="{{ route('disponibilidades.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-3 px-6 rounded-lg transition">
            <i class="fas fa-plus"></i> Agregar Disponibilidad
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
            {{ session('success') }}
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
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition" onclick="return confirm('¿Estás seguro de que deseas eliminar esta disponibilidad?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-blue-50 border-l-4 border-blue-500 p-8 rounded-lg text-center">
            <i class="fas fa-calendar-times text-4xl text-blue-500 mb-4 block"></i>
            <p class="text-gray-600 mb-4 text-lg">No tienes disponibilidades creadas aún.</p>
            <a href="{{ route('disponibilidades.create') }}" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-800 font-bold py-2 px-6 rounded-lg transition">
                <i class="fas fa-plus"></i> Crear tu primera disponibilidad
            </a>
        </div>
    @endif
</div>
@endsection