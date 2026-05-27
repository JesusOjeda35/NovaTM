@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- LISTA DE CONVERSACIONES -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="p-4 border-b">
                    <a href="{{ route('productor.mensajes') }}" class="text-sm text-blue-600 hover:underline">
                        ← Volver
                    </a>
                </div>
            </div>
        </div>

        <!-- CHAT -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-lg shadow flex flex-col h-screen">
                <!-- HEADER -->
                <div class="p-4 border-b flex justify-between items-center">
                    <div>
                        <h2 class="font-bold">{{ $usuarioChat->nombre_completo }}</h2>
                        <p class="text-sm text-gray-500">
                            @if($usuarioChat->estado === 'A')
                                <span class="text-green-500">● En línea</span>
                            @else
                                <span class="text-gray-500">● Desconectado</span>
                            @endif
                        </p>
                    </div>
                    <button class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>

                <!-- MENSAJES -->
                <div class="flex-1 overflow-y-auto p-4 bg-gray-50">
                    @foreach($mensajes as $msg)
                        <div class="mb-4 flex {{ $msg->Users_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs bg-{{ $msg->Users_id === auth()->id() ? 'green' : 'white' }}-100 border border-{{ $msg->Users_id === auth()->id() ? 'green' : 'gray' }}-300 rounded-lg p-3">
                                <p class="text-sm">{{ $msg->contenido }}</p>
                                
                                @if($msg->tieneAdjunto())
                                    <a href="{{ asset($msg->url_adjunto) }}" download class="text-blue-600 text-xs hover:underline">
                                        <i class="fas fa-download"></i> Descargar archivo
                                    </a>
                                @endif
                                
                                <p class="text-xs text-gray-500 mt-1">{{ $msg->getHoraFormato() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- INPUT -->
                <div class="p-4 border-t">
                    <form action="{{ route('mensaje.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
                        @csrf
                        <input type="hidden" name="Users_id2" value="{{ $usuarioChat->id }}">
                        
                        <input type="text" name="contenido" placeholder="Escribe un mensaje..." class="flex-1 px-3 py-2 border rounded-md text-sm" required>
                        
                        <label class="cursor-pointer">
                            <input type="file" name="archivo" class="hidden" accept=".pdf,.doc,.docx,.jpg,.png">
                            <span class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-paperclip text-lg"></i>
                            </span>
                        </label>
                        
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection