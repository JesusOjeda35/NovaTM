@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Nueva Receta</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
            <p class="font-bold">Error al crear la receta:</p>
            <ul class="text-sm mt-2">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profesional.recetas.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <!-- Seleccionar Consulta -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Consulta *</label>
            <select name="consultas_id_consulta" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required onchange="cargarDatosConsulta(this)">
                <option value="">-- Selecciona una consulta --</option>
                @foreach ($consultas as $consulta)
                    <option value="{{ $consulta->id_consulta }}" data-animal="{{ $consulta->animal->nombre }}" data-especie="{{ $consulta->animal->especie }}" data-user="{{ $consulta->User->nombre_completo }}">
                        {{ $consulta->animal->nombre }} ({{ $consulta->animal->especie }}) - {{ $consulta->User->nombre_completo }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Datos del Animal (solo lectura) -->
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Animal</label>
                <input type="text" id="animal_nombre" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2">Especie</label>
                <input type="text" id="animal_especie" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-bold mb-2">Dueño</label>
                <input type="text" id="animal_user" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" readonly>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Diagnóstico *</label>
            <textarea name="diagnostico" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="4" placeholder="Describe el diagnóstico del animal..." required>{{ old('diagnostico') }}</textarea>
        </div>

        <!-- Indicaciones Generales -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Indicaciones Generales</label>
            <textarea name="indicaciones_generales" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="3" placeholder="Ej: Limpiar el ojo con la solución indicadas antes de aplicar el medicamento...">{{ old('indicaciones_generales') }}</textarea>
        </div>

        <!-- Medicamentos -->
        <div class="mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Medicamentos</h3>
            <div id="medicamentos-container">
                <div class="medicamento-item bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Medicamento -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Medicamento *</label>
                            <select name="medicamentos[0][medicamentos_id_medicamento]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required onchange="cargarDatosMedicamento(this)">
                                <option value="">-- Selecciona un medicamento --</option>
                                @foreach ($medicamentos->groupBy('categoria') as $categoria => $meds)
                                    <optgroup label="{{ $categoria }}">
                                        @foreach ($meds as $med)
                                            <option value="{{ $med->id_medicamento }}" data-dosis="{{ $med->dosis_recomendada }}" data-via="{{ $med->via_administracion }}">
                                                {{ $med->nombre }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dosis -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Dosis *</label>
                            <input type="text" name="medicamentos[0][dosis]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: 10 ml, 500 mg" required>
                        </div>

                        <!-- Vía de Administración -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Vía de Administración</label>
                            <input type="text" name="medicamentos[0][via_administracion]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: IM, Oral, IV">
                        </div>

                        <!-- Frecuencia -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Frecuencia *</label>
                            <input type="text" name="medicamentos[0][frecuencia]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: Cada 12 horas, 2 veces al día" required>
                        </div>

                        <!-- Duración -->
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Duración *</label>
                            <input type="text" name="medicamentos[0][duracion]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: 7 días, 10 días" required>
                        </div>
                    </div>
                    <button type="button" class="mt-3 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition text-sm eliminar-medicamento" style="display: none;">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>

            <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition" onclick="agregarMedicamento()">
                <i class="fas fa-plus"></i> Agregar Medicamento
            </button>
        </div>

        <!-- Notas Adicionales -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Notas Adicionales</label>
            <textarea name="notas_adicionales" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" rows="3" placeholder="Notas adicionales para el productor...">{{ old('notas_adicionales') }}</textarea>
        </div>

        <!-- Botones -->
        <div class="flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition">
                <i class="fas fa-save"></i> Guardar Receta
            </button>
            <a href="{{ route('profesional.recetas') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded transition">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<script>
let medicamentoIndex = 0;

function cargarDatosConsulta(select) {
    document.getElementById('animal_nombre').value = select.options[select.selectedIndex].dataset.animal;
    document.getElementById('animal_especie').value = select.options[select.selectedIndex].dataset.especie;
    document.getElementById('animal_user').value = select.options[select.selectedIndex].dataset.user;
}

function agregarMedicamento() {
    medicamentoIndex++;
    const container = document.getElementById('medicamentos-container');
    const html = `
        <div class="medicamento-item bg-gray-50 p-4 rounded-lg mb-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Medicamento *</label>
                    <select name="medicamentos[${medicamentoIndex}][medicamentos_id_medicamento]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required onchange="cargarDatosMedicamento(this)">
                        <option value="">-- Selecciona un medicamento --</option>
                        @foreach ($medicamentos->groupBy('categoria') as $categoria => $meds)
                            <optgroup label="{{ $categoria }}">
                                @foreach ($meds as $med)
                                    <option value="{{ $med->id_medicamento }}" data-dosis="{{ $med->dosis_recomendada }}" data-via="{{ $med->via_administracion }}">
                                        {{ $med->nombre }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Dosis *</label>
                    <input type="text" name="medicamentos[${medicamentoIndex}][dosis]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: 10 ml, 500 mg" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Vía de Administración</label>
                    <input type="text" name="medicamentos[${medicamentoIndex}][via_administracion]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: IM, Oral, IV">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Frecuencia *</label>
                    <input type="text" name="medicamentos[${medicamentoIndex}][frecuencia]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: Cada 12 horas, 2 veces al día" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-2">Duración *</label>
                    <input type="text" name="medicamentos[${medicamentoIndex}][duracion]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Ej: 7 días, 10 días" required>
                </div>
            </div>
            <button type="button" class="mt-3 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition text-sm eliminar-medicamento" onclick="eliminarMedicamento(this)">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    actualizarBotonesEliminar();
}

function eliminarMedicamento(btn) {
    btn.closest('.medicamento-item').remove();
    actualizarBotonesEliminar();
}

function actualizarBotonesEliminar() {
    const items = document.querySelectorAll('.medicamento-item');
    items.forEach((item, index) => {
        const btn = item.querySelector('.eliminar-medicamento');
        btn.style.display = items.length > 1 ? 'block' : 'none';
    });
}

function cargarDatosMedicamento(select) {
    const dosis = select.options[select.selectedIndex].dataset.dosis;
    const via = select.options[select.selectedIndex].dataset.via;
    const parent = select.closest('.medicamento-item');
    
    const dosisInput = parent.querySelector('input[name*="[dosis]"]');
    const viaInput = parent.querySelector('input[name*="[via_administracion]"]');
    
    if (dosis) dosisInput.value = dosis;
    if (via) viaInput.value = via;
}

// Inicializar
actualizarBotonesEliminar();
</script>
@endsection