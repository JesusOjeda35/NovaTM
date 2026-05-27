 @extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold" style="color: #14202A;">💬 Mensajes</h1>
        <a href="{{ route('mensaje.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
            <i class="fas fa-plus"></i> Nuevo mensaje
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- LISTA DE CONVERSACIONES -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <input type="text" placeholder="Buscar conversación..." class="w-full px-3 py-2 border rounded-md text-sm">
                </div>
                
                <div class="divide-y max-h-screen overflow-y-auto">
                    @forelse($conversaciones as $conv)
                        <a href="{{ route('mensaje.show', $conv['usuario']->id) }}" class="block p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/default-avatar.png') }}" alt="{{ $conv['usuario']->nombre_completo }}" class="w-10 h-10 rounded-full object-cover">
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-sm truncate">{{ $conv['usuario']->nombre_completo }}</h3>
                                    <p class="text-xs text-gray-500 truncate">{{ $conv['ultimo_mensaje']->contenido }}</p>
                                </div>
                                @if($conv['no_leidos'] > 0)
                                    <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1">{{ $conv['no_leidos'] }}</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="p-6 text-center text-gray-500">
                            <p class="text-sm">No hay conversaciones aún</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ÁREA DE CHAT (vacía al inicio) -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow h-screen flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-comments text-5xl mb-4 opacity-50"></i>
                    <p class="text-lg">Selecciona una conversación</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection