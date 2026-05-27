@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">📄 Historial Clínico Completo</h1>
        <div class="flex gap-2">
            @if(auth()->user()->isProfesional() && $historial->esProfesional(auth()->user()->id))
                <a href="{{ route('historial.edit', $historial->id_historial) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition">
                    ✏️ Editar
                </a>
            @endif
            <a href="{{ route('historial.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition">
                ← Volver
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-800 rounded">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- ENCABEZADO -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 pb-8 border-b">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Número de Historia</p>
                <p class="text-2xl font-bold text-blue-600">HC - {{ $historial->id_historial }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Fecha de Atención</p>
                <p class="text-lg font-bold text-green-600">{{ $historial->fecha->format('d/m/Y H:i') }}</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Tipo de Evento</p>
                <p class="text-lg font-bold text-purple-600">{{ $historial->tipo_evento }}</p>
            </div>
            <div class="bg-orange-50 p-4 rounded-lg">
                <p class="text-sm text-gray-600">Estado</p>
                <p class="text-lg font-bold text-orange-600">
                    {{ $historial->isSincronizado() ? '✓ Sincronizado' : 'Pendiente' }}
                </p>
            </div>
        </div>

        <!-- DATOS DEL PRODUCTOR Y ANIMAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b">
            <!-- Productor -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">👤 Datos del Productor</h2>
                <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="font-semibold text-gray-800">{{ $historial->animal->user->nombre_completo ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold text-blue-600">{{ $historial->animal->user->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Teléfono</p>
                        <p class="font-semibold text-gray-800">{{ $historial->animal->user->telefono ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Ganadería</p>
                        <p class="font-semibold text-gray-800">{{ $historial->animal->user->nombre_ganaderia ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Animal -->
            <div>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">🐄 Reseña del Animal</h2>
                <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Nombre / Alias</p>
                        <p class="font-semibold text-gray-800">{{ $historial->animal->nombre ?? 'N/A' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Especie</p>
                            <p class="font-semibold text-gray-800">{{ $historial->animal->especie ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Raza</p>
                            <p class="font-semibold text-gray-800">{{ $historial->animal->raza ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Sexo</p>
                            <p class="font-semibold text-gray-800">{{ $historial->animal->sexo ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Peso</p>
                            <p class="font-semibold text-gray-800">{{ $historial->animal->peso ?? 'N/A' }} kg</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Color y Marcas</p>
                        <p class="font-semibold text-gray-800">{{ $historial->animal->color_marcas ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROFESIONAL -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">👨‍⚕️ Profesional Tratante</h2>
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="font-semibold text-gray-800">{{ $historial->User->nombre_completo ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Especialidad</p>
                        <p class="font-semibold text-gray-800">{{ $historial->User->especialidad ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold text-blue-600">{{ $historial->User->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANAMNESIS -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-2xl font-bold mb-4 text-blue-600">📋 Anamnesis</h2>
            <div class="grid grid-cols-1 gap-6">
                @if($historial->descripcion)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Motivo de Consulta</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->descripcion }}</p>
                    </div>
                @endif

                @if($historial->alimentacion_dieta)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Alimentación / Dieta</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->alimentacion_dieta }}</p>
                    </div>
                @endif

                @if($historial->enfermedades_previas)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Enfermedades Previas</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->enfermedades_previas }}</p>
                    </div>
                @endif

                @if($historial->cirugias_previas)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Cirugías Previas</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->cirugias_previas }}</p>
                    </div>
                @endif

                @if($historial->numero_partos)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Número de Partos</p>
                        <p class="text-gray-800">{{ $historial->numero_partos }}</p>
                    </div>
                @endif

                @if($historial->esquema_vacunal)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Esquema Vacunal</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->esquema_vacunal }}</p>
                    </div>
                @endif

                @if($historial->ultima_desparasitacion)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Última Desparasitación</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->ultima_desparasitacion }}</p>
                    </div>
                @endif

                @if($historial->tratamientos_recientes)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">Tratamientos Recientes</p>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->tratamientos_recientes }}</p>
                    </div>
                @endif

                @if($historial->convive_otros_animales)
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-bold text-gray-600 mb-2">¿Convive con otros animales?</p>
                        <p class="text-gray-800">Sí @if($historial->cuales_animales) - {{ $historial->cuales_animales }} @endif</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- EXAMEN FÍSICO -->
        @if($historial->temperatura || $historial->frecuencia_cardiaca || $historial->frecuencia_respiratoria || $historial->otros_hallazgos_fisicos)
            <div class="mb-8 pb-8 border-b">
                <h2 class="text-2xl font-bold mb-4 text-green-600">🔬 Examen Físico</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($historial->temperatura)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm font-bold text-gray-600">Temperatura</p>
                            <p class="text-lg font-semibold text-green-600">{{ $historial->temperatura }}°C</p>
                        </div>
                    @endif

                    @if($historial->frecuencia_cardiaca)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm font-bold text-gray-600">Frecuencia Cardíaca</p>
                            <p class="text-lg font-semibold text-green-600">{{ $historial->frecuencia_cardiaca }} lpm</p>
                        </div>
                    @endif

                    @if($historial->frecuencia_respiratoria)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm font-bold text-gray-600">Frecuencia Respiratoria</p>
                            <p class="text-lg font-semibold text-green-600">{{ $historial->frecuencia_respiratoria }} rpm</p>
                        </div>
                    @endif

                    @if($historial->otros_hallazgos_fisicos)
                        <div class="bg-green-50 p-4 rounded-lg col-span-full">
                            <p class="text-sm font-bold text-gray-600 mb-2">Otros Hallazgos Físicos</p>
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->otros_hallazgos_fisicos }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- EVALUACIÓN PROFESIONAL -->
        <div class="mb-8 pb-8 border-b">
            <h2 class="text-2xl font-bold mb-4 text-red-600">👨‍⚕️ Evaluación Profesional</h2>

            @if($historial->diagnostico)
                <div class="bg-red-50 p-4 rounded-lg mb-4 border-l-4 border-red-600">
                    <p class="text-sm font-bold text-gray-600 mb-2">Diagnóstico</p>
                    <p class="text-gray-800 whitespace-pre-wrap font-semibold">{{ $historial->diagnostico }}</p>
                </div>
            @endif

            @if($historial->tratamiento)
                <div class="bg-orange-50 p-4 rounded-lg mb-4 border-l-4 border-orange-600">
                    <p class="text-sm font-bold text-gray-600 mb-2">Tratamiento Recomendado</p>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->tratamiento }}</p>
                </div>
            @endif

            @if($historial->observaciones)
                <div class="bg-yellow-50 p-4 rounded-lg mb-4 border-l-4 border-yellow-600">
                    <p class="text-sm font-bold text-gray-600 mb-2">Observaciones</p>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->observaciones }}</p>
                </div>
            @endif

            @if($historial->recomendaciones_finales)
                <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-600">
                    <p class="text-sm font-bold text-gray-600 mb-2">Recomendaciones Finales</p>
                    <p class="text-gray-800 whitespace-pre-wrap">{{ $historial->recomendaciones_finales }}</p>
                </div>
            @endif
        </div>

        <!-- BOTONES FINALES -->
        <div class="flex gap-3 flex-wrap">
            @if(auth()->user()->isProfesional() && $historial->esProfesional(auth()->user()->id))
                <a href="{{ route('historial.edit', $historial->id_historial) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded transition">
                    ✏️ Editar
                </a>
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                    🖨️ Imprimir
                </button>
                <a href="{{ route('historial.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition">
                    ← Volver
                </a>
            @else
                <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                    🖨️ Imprimir
                </button>
                <a href="{{ route('historial.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition">
                    ← Volver
                </a>
            @endif
        </div>
    </div>
</div>
@endsection