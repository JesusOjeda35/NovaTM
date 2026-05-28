@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h1 class="mb-4">Nueva Receta</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Hay errores en el formulario:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profesional.recetas.store') }}" method="POST">
        @csrf

        {{-- CONSULTA --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="mb-3">
                    <label for="consultas_id_consulta" class="form-label">
                        Consulta <span class="text-danger">*</span>
                    </label>

                    <select
                        name="consultas_id_consulta"
                        id="consultas_id_consulta"
                        class="form-control @error('consultas_id_consulta') is-invalid @enderror"
                        required
                        onchange="cargarDatosConsulta(this)"
                    >
                        <option value="">-- Selecciona una consulta --</option>

                        @forelse($consultas as $consulta)
                            <option
                                value="{{ $consulta->id_consulta }}"
                                data-animal="{{ $consulta->animal->nombre ?? '' }}"
                                data-especie="{{ $consulta->animal->especie ?? '' }}"
                                data-dueno="{{ $consulta->User->nombre_completo ?? $consulta->User->name ?? 'Sin dueño' }}"
                                data-diagnostico="{{ $consulta->diagnostico_resumido ?? '' }}"
                                data-recomendaciones="{{ $consulta->recomendaciones ?? '' }}"
                                {{ old('consultas_id_consulta') == $consulta->id_consulta ? 'selected' : '' }}
                            >
                                #{{ $consulta->id_consulta }}
                                -
                                {{ $consulta->animal->nombre ?? 'Sin animal' }}
                                /
                                {{ $consulta->animal->especie ?? 'Sin especie' }}
                                -
                                Dueño: {{ $consulta->User->nombre_completo ?? $consulta->User->name ?? 'Sin dueño' }}
                                -
                                Estado: {{ ucfirst($consulta->estado) }}
                            </option>
                        @empty
                            <option value="" disabled>
                                No hay consultas disponibles para crear receta
                            </option>
                        @endforelse
                    </select>

                    @error('consultas_id_consulta')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @if($consultas->isEmpty())
                        <small class="text-muted d-block mt-2">
                            No aparecen consultas disponibles. Revisa que existan consultas con estado agendada, pendiente o atendida, y que todavía no tengan receta.
                        </small>
                    @endif
                </div>

                {{-- DATOS AUTOMÁTICOS --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="animal_nombre" class="form-label">Animal</label>
                        <input
                            type="text"
                            id="animal_nombre"
                            class="form-control"
                            readonly
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="animal_especie" class="form-label">Especie</label>
                        <input
                            type="text"
                            id="animal_especie"
                            class="form-control"
                            readonly
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label for="animal_dueno" class="form-label">Dueño / Productor</label>
                    <input
                        type="text"
                        id="animal_dueno"
                        class="form-control"
                        readonly
                    >
                </div>

            </div>
        </div>

        {{-- DIAGNÓSTICO --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">
                Diagnóstico <span class="text-danger">*</span>
            </label>

            <textarea
                name="diagnostico"
                id="diagnostico"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('diagnostico') is-invalid @enderror"
                rows="4"
                placeholder="Describe el diagnóstico del animal..."
                required
            >{{ old('diagnostico') }}</textarea>

            @error('diagnostico')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- INDICACIONES GENERALES --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">
                Indicaciones Generales
            </label>

            <textarea
                name="indicaciones_generales"
                id="indicaciones_generales"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('indicaciones_generales') is-invalid @enderror"
                rows="3"
                placeholder="Ej: Limpiar el ojo con la solución indicada antes de aplicar el medicamento..."
            >{{ old('indicaciones_generales') }}</textarea>

            @error('indicaciones_generales')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- FECHA DE VENCIMIENTO --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">
                Fecha de vencimiento
            </label>

            <input
                type="date"
                name="fecha_vencimiento"
                id="fecha_vencimiento"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('fecha_vencimiento') is-invalid @enderror"
                value="{{ old('fecha_vencimiento') }}"
            >

            @error('fecha_vencimiento')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- MEDICAMENTOS --}}
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Medicamentos</h3>

            <div id="medicamentos-container">
                <div class="medicamento-item bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- MEDICAMENTO --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">
                                Medicamento <span class="text-danger">*</span>
                            </label>

                            <select
                                name="medicamentos[0][medicamentos_id_medicamento]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                required
                                onchange="cargarDatosMedicamento(this)"
                            >
                                <option value="">-- Selecciona un medicamento --</option>

                                @foreach ($medicamentos->groupBy('categoria') as $categoria => $meds)
                                    <optgroup label="{{ $categoria }}">
                                        @foreach ($meds as $med)
                                            <option
                                                value="{{ $med->id_medicamento }}"
                                                data-dosis="{{ $med->dosis_recomendada }}"
                                                data-via="{{ $med->via_administracion }}"
                                            >
                                                {{ $med->nombre }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- DOSIS --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">
                                Dosis <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="medicamentos[0][dosis]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                placeholder="Ej: 10 ml, 500 mg"
                                required
                            >
                        </div>

                        {{-- VÍA DE ADMINISTRACIÓN --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">
                                Vía de Administración
                            </label>

                            <input
                                type="text"
                                name="medicamentos[0][via_administracion]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                placeholder="Ej: IM, Oral, IV"
                            >
                        </div>

                        {{-- FRECUENCIA --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">
                                Frecuencia <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="medicamentos[0][frecuencia]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                placeholder="Ej: Cada 12 horas, 2 veces al día"
                                required
                            >
                        </div>

                        {{-- DURACIÓN --}}
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">
                                Duración <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="medicamentos[0][duracion]"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                                placeholder="Ej: 7 días, 10 días"
                                required
                            >
                        </div>

                    </div>

                    <button
                        type="button"
                        class="mt-3 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition text-sm eliminar-medicamento"
                        onclick="eliminarMedicamento(this)"
                        style="display: none;"
                    >
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <button
                type="button"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition"
                onclick="agregarMedicamento()"
            >
                <i class="fas fa-plus"></i> Agregar Medicamento
            </button>
        </div>

        {{-- NOTAS ADICIONALES --}}
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">
                Notas Adicionales
            </label>

            <textarea
                name="notas_adicionales"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 @error('notas_adicionales') is-invalid @enderror"
                rows="3"
                placeholder="Notas adicionales para el productor..."
            >{{ old('notas_adicionales') }}</textarea>

            @error('notas_adicionales')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- BOTONES --}}
        <div class="flex gap-4">
            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition"
            >
                <i class="fas fa-save"></i> Guardar Receta
            </button>

            <a
                href="{{ route('profesional.recetas') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded transition"
            >
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>

    </form>
</div>

<script>
let medicamentoIndex = 0;

function cargarDatosConsulta(select) {
    const option = select.options[select.selectedIndex];

    if (!option || !option.value) {
        document.getElementById('animal_nombre').value = '';
        document.getElementById('animal_especie').value = '';
        document.getElementById('animal_dueno').value = '';
        return;
    }

    const animal = option.dataset.animal || '';
    const especie = option.dataset.especie || '';
    const dueno = option.dataset.dueno || '';
    const diagnostico = option.dataset.diagnostico || '';
    const recomendaciones = option.dataset.recomendaciones || '';

    document.getElementById('animal_nombre').value = animal;
    document.getElementById('animal_especie').value = especie;
    document.getElementById('animal_dueno').value = dueno;

    const diagnosticoInput = document.getElementById('diagnostico');
    const indicacionesInput = document.getElementById('indicaciones_generales');

    if (diagnosticoInput && diagnostico !== '') {
        diagnosticoInput.value = diagnostico;
    }

    if (indicacionesInput && recomendaciones !== '') {
        indicacionesInput.value = recomendaciones;
    }
}

function agregarMedicamento() {
    medicamentoIndex++;

    const container = document.getElementById('medicamentos-container');

    const html = `
        <div class="medicamento-item bg-gray-50 p-4 rounded-lg mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        Medicamento <span class="text-danger">*</span>
                    </label>

                    <select
                        name="medicamentos[${medicamentoIndex}][medicamentos_id_medicamento]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                        onchange="cargarDatosMedicamento(this)"
                    >
                        <option value="">-- Selecciona un medicamento --</option>

                        @foreach ($medicamentos->groupBy('categoria') as $categoria => $meds)
                            <optgroup label="{{ $categoria }}">
                                @foreach ($meds as $med)
                                    <option
                                        value="{{ $med->id_medicamento }}"
                                        data-dosis="{{ $med->dosis_recomendada }}"
                                        data-via="{{ $med->via_administracion }}"
                                    >
                                        {{ $med->nombre }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        Dosis <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="medicamentos[${medicamentoIndex}][dosis]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Ej: 10 ml, 500 mg"
                        required
                    >
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        Vía de Administración
                    </label>

                    <input
                        type="text"
                        name="medicamentos[${medicamentoIndex}][via_administracion]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Ej: IM, Oral, IV"
                    >
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        Frecuencia <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="medicamentos[${medicamentoIndex}][frecuencia]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Ej: Cada 12 horas, 2 veces al día"
                        required
                    >
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2">
                        Duración <span class="text-danger">*</span>
                    </label>

                    <input
                        type="text"
                        name="medicamentos[${medicamentoIndex}][duracion]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Ej: 7 días, 10 días"
                        required
                    >
                </div>

            </div>

            <button
                type="button"
                class="mt-3 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition text-sm eliminar-medicamento"
                onclick="eliminarMedicamento(this)"
            >
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    actualizarBotonesEliminar();
}

function eliminarMedicamento(btn) {
    const item = btn.closest('.medicamento-item');

    if (item) {
        item.remove();
    }

    actualizarBotonesEliminar();
}

function actualizarBotonesEliminar() {
    const items = document.querySelectorAll('.medicamento-item');

    items.forEach((item) => {
        const btn = item.querySelector('.eliminar-medicamento');

        if (btn) {
            btn.style.display = items.length > 1 ? 'block' : 'none';
        }
    });
}

function cargarDatosMedicamento(select) {
    const option = select.options[select.selectedIndex];

    if (!option) {
        return;
    }

    const dosis = option.dataset.dosis || '';
    const via = option.dataset.via || '';

    const parent = select.closest('.medicamento-item');

    if (!parent) {
        return;
    }

    const dosisInput = parent.querySelector('input[name*="[dosis]"]');
    const viaInput = parent.querySelector('input[name*="[via_administracion]"]');

    if (dosisInput && dosis !== '') {
        dosisInput.value = dosis;
    }

    if (viaInput && via !== '') {
        viaInput.value = via;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    actualizarBotonesEliminar();

    const selectConsulta = document.getElementById('consultas_id_consulta');

    if (selectConsulta && selectConsulta.value !== '') {
        cargarDatosConsulta(selectConsulta);
    }
});
</script>
@endsection