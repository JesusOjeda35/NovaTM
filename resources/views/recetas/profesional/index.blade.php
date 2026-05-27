@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mis Recetas</h1>
        <a href="{{ route('profesional.recetas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
            <i class="fas fa-plus"></i> Nueva Receta
        </a>
    </div>

    @if ($recetas->isEmpty())
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded">
            <p class="font-bold">No hay recetas creadas aún</p>
            <p class="text-sm mt-2">Crea una nueva receta para tus consultas completadas</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($recetas as $receta)
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition border-l-4 border-green-500">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">
                                {{ $receta->animal->nombre }}
                                <span class="text-sm font-normal text-gray-600">({{ $receta->animal->especie }})</span>
                            </h3>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-user"></i> {{ $receta->animal->user->nombre_completo }}
                            </p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold @if($receta->isActiva()) bg-green-200 text-green-800 @else bg-red-200 text-red-800 @endif">
                            {{ ucfirst($receta->estado) }}
                        </span>
                    </div>

                    <div class="mb-4 text-sm text-gray-700">
                        <p><strong>Diagnóstico:</strong> {{ Str::limit($receta->diagnostico, 60) }}</p>
                        <p class="text-gray-600 mt-1"><i class="far fa-calendar"></i> {{ $receta->fecha_emision->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">
                            {{ $receta->medicamentos->count() }} medicamento{{ $receta->medicamentos->count() != 1 ? 's' : '' }}
                        </span>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('profesional.recetas.show', $receta->id_receta) }}" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-3 rounded text-center transition text-sm">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('profesional.recetas.edit', $receta->id_receta) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-3 rounded text-center transition text-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('profesional.recetas.destroy', $receta->id_receta) }}" method="POST" class="flex-1" onsubmit="return confirm('¿Eliminar receta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-3 rounded transition text-sm">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $recetas->links() }}
        </div>
    @endif
</div>
@endsection