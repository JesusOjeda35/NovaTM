@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6" style="color: #14202A;">Nuevo Mensaje</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('mensaje.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Selecciona un profesional</label>
                <select name="Users_id2" class="w-full px-3 py-2 border rounded-md" required>
                    <option value="">Elige un veterinario o especialista...</option>
                    @foreach($profesionales as $prof)
                        <option value="{{ $prof->id }}">
                            {{ $prof->nombre_completo }} 
                            @if($prof->rol === 'veterinario')
                                (Veterinario)
                            @else
                                (Especialista)
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('Users_id2') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Mensaje</label>
                <textarea name="contenido" rows="6" class="w-full px-3 py-2 border rounded-md" placeholder="Escribe tu mensaje..." required></textarea>
                @error('contenido') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Adjuntar archivo (opcional)</label>
                <input type="file" name="archivo" class="w-full px-3 py-2 border rounded-md" accept=".pdf,.doc,.docx,.jpg,.png">
                @error('archivo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition">
                    Enviar Mensaje
                </button>
                <a href="{{ route('productor.mensajes') }}" class="px-6 py-2 border rounded-md hover:bg-gray-50 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection