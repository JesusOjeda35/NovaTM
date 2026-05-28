<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Medicamento;
use App\Models\RecetaMedicamentos;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecetaController extends Controller
{
    // ========== VISTAS PROFESIONAL ==========

    public function indexProfesional()
    {
        $User = auth()->user();

        /*
         * IMPORTANTE:
         * Se usa paginate(10) porque tu vista index.blade.php usa:
         * {{ $recetas->links() }}
         */
        $recetas = Receta::where('user_id', $User->id)
            ->with(['animal.user', 'consulta', 'medicamentos.medicamento', 'User'])
            ->latest('id_receta')
            ->paginate(10);

        return view('recetas.profesional.index', compact('recetas'));
    }

    public function create()
    {
        /*
         * Corrección:
         * Antes solo traías consultas con estado "atendida".
         * Ahora trae consultas agendadas, pendientes o atendidas.
         */
        $consultas = Consulta::whereIn('estado', ['agendada', 'pendiente', 'atendida'])
            ->whereDoesntHave('recetas')
            ->with(['animal', 'User'])
            ->orderBy('id_consulta', 'desc')
            ->get();

        $medicamentos = Medicamento::orderBy('categoria')
            ->orderBy('nombre')
            ->get();

        return view('recetas.profesional.create', compact('consultas', 'medicamentos'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $validated = $request->validate([
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'diagnostico' => 'required|string|max:5000',
            'indicaciones_generales' => 'nullable|string|max:5000',
            'notas_adicionales' => 'nullable|string|max:5000',
            'fecha_vencimiento' => 'nullable|date',

            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamentos_id_medicamento' => 'required|exists:medicamentos,id_medicamento',
            'medicamentos.*.dosis' => 'required|string|max:255',
            'medicamentos.*.frecuencia' => 'required|string|max:255',
            'medicamentos.*.duracion' => 'required|string|max:255',
            'medicamentos.*.via_administracion' => 'nullable|string|max:255',
            'medicamentos.*.instrucciones' => 'nullable|string|max:1000',
        ], [
            'consultas_id_consulta.required' => 'Debes seleccionar una consulta.',
            'consultas_id_consulta.exists' => 'La consulta seleccionada no existe.',

            'diagnostico.required' => 'El diagnóstico es obligatorio.',

            'medicamentos.required' => 'Debes agregar al menos un medicamento.',
            'medicamentos.array' => 'El formato de medicamentos no es válido.',
            'medicamentos.min' => 'Debes agregar al menos un medicamento.',

            'medicamentos.*.medicamentos_id_medicamento.required' => 'Debes seleccionar un medicamento.',
            'medicamentos.*.medicamentos_id_medicamento.exists' => 'El medicamento seleccionado no existe.',
            'medicamentos.*.dosis.required' => 'La dosis del medicamento es obligatoria.',
            'medicamentos.*.frecuencia.required' => 'La frecuencia del medicamento es obligatoria.',
            'medicamentos.*.duracion.required' => 'La duración del medicamento es obligatoria.',
        ]);

        $consulta = Consulta::with(['animal', 'User'])
            ->where('id_consulta', $validated['consultas_id_consulta'])
            ->firstOrFail();

        $recetaExistente = Receta::where('consultas_id_consulta', $consulta->id_consulta)->first();

        if ($recetaExistente) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Esta consulta ya tiene una receta registrada.');
        }

        DB::beginTransaction();

        try {
            $receta = Receta::create([
                'user_id' => $User->id,
                'animales_id_animal' => $consulta->animales_id_animal,
                'consultas_id_consulta' => $consulta->id_consulta,
                'diagnostico' => $validated['diagnostico'],
                'indicaciones_generales' => $validated['indicaciones_generales'] ?? null,
                'notas_adicionales' => $validated['notas_adicionales'] ?? null,
                'fecha_emision' => now(),
                'fecha_vencimiento' => $validated['fecha_vencimiento'] ?? null,
                'firma_electronica' => null,
                'estado' => 'activa',
                'sincronizado' => 'N',
            ]);

            foreach ($validated['medicamentos'] as $med) {
                $medicamento = Medicamento::where('id_medicamento', $med['medicamentos_id_medicamento'])
                    ->firstOrFail();

                RecetaMedicamentos::create([
                    'recetas_id' => $receta->id_receta,
                    'medicamentos_id_medicamento' => $med['medicamentos_id_medicamento'],
                    'nombre_medicamento' => $medicamento->nombre,
                    'dosis' => $med['dosis'],
                    'via_administracion' => $med['via_administracion'] ?? $medicamento->via_administracion ?? null,
                    'frecuencia' => $med['frecuencia'],
                    'duracion' => $med['duracion'],
                    'instrucciones' => $med['instrucciones'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('profesional.recetas.show', $receta->id_receta)
                ->with('success', 'Receta creada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la receta: ' . $e->getMessage());
        }
    }

    public function showProfesional(Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $receta->load([
            'animal.user',
            'consulta',
            'medicamentos.medicamento',
            'User',
        ]);

        return view('recetas.profesional.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $medicamentos = Medicamento::orderBy('categoria')
            ->orderBy('nombre')
            ->get();

        $receta->load([
            'animal.user',
            'consulta',
            'medicamentos.medicamento',
            'User',
        ]);

        return view('recetas.profesional.edit', compact('receta', 'medicamentos'));
    }

    public function update(Request $request, Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'diagnostico' => 'required|string|max:5000',
            'indicaciones_generales' => 'nullable|string|max:5000',
            'notas_adicionales' => 'nullable|string|max:5000',
            'fecha_vencimiento' => 'nullable|date',

            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamentos_id_medicamento' => 'required|exists:medicamentos,id_medicamento',
            'medicamentos.*.dosis' => 'required|string|max:255',
            'medicamentos.*.frecuencia' => 'required|string|max:255',
            'medicamentos.*.duracion' => 'required|string|max:255',
            'medicamentos.*.via_administracion' => 'nullable|string|max:255',
            'medicamentos.*.instrucciones' => 'nullable|string|max:1000',
        ], [
            'diagnostico.required' => 'El diagnóstico es obligatorio.',

            'medicamentos.required' => 'Debes agregar al menos un medicamento.',
            'medicamentos.*.medicamentos_id_medicamento.required' => 'Debes seleccionar un medicamento.',
            'medicamentos.*.medicamentos_id_medicamento.exists' => 'El medicamento seleccionado no existe.',
            'medicamentos.*.dosis.required' => 'La dosis del medicamento es obligatoria.',
            'medicamentos.*.frecuencia.required' => 'La frecuencia del medicamento es obligatoria.',
            'medicamentos.*.duracion.required' => 'La duración del medicamento es obligatoria.',
        ]);

        DB::beginTransaction();

        try {
            $receta->update([
                'diagnostico' => $validated['diagnostico'],
                'indicaciones_generales' => $validated['indicaciones_generales'] ?? null,
                'notas_adicionales' => $validated['notas_adicionales'] ?? null,
                'fecha_vencimiento' => $validated['fecha_vencimiento'] ?? null,
                'sincronizado' => 'N',
            ]);

            RecetaMedicamentos::where('recetas_id', $receta->id_receta)->delete();

            foreach ($validated['medicamentos'] as $med) {
                $medicamento = Medicamento::where('id_medicamento', $med['medicamentos_id_medicamento'])
                    ->firstOrFail();

                RecetaMedicamentos::create([
                    'recetas_id' => $receta->id_receta,
                    'medicamentos_id_medicamento' => $med['medicamentos_id_medicamento'],
                    'nombre_medicamento' => $medicamento->nombre,
                    'dosis' => $med['dosis'],
                    'via_administracion' => $med['via_administracion'] ?? $medicamento->via_administracion ?? null,
                    'frecuencia' => $med['frecuencia'],
                    'duracion' => $med['duracion'],
                    'instrucciones' => $med['instrucciones'] ?? null,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('profesional.recetas.show', $receta->id_receta)
                ->with('success', 'Receta actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la receta: ' . $e->getMessage());
        }
    }

    public function destroy(Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        DB::beginTransaction();

        try {
            RecetaMedicamentos::where('recetas_id', $receta->id_receta)->delete();

            $receta->delete();

            DB::commit();

            return redirect()
                ->route('profesional.recetas')
                ->with('success', 'Receta eliminada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error al eliminar la receta: ' . $e->getMessage());
        }
    }

    // ========== VISTAS PRODUCTOR ==========

    public function indexProductor()
    {
        $User = auth()->user();

        $recetas = Receta::whereIn('animales_id_animal', function ($query) use ($User) {
                $query->select('id_animal')
                    ->from('animales')
                    ->where('user_id', $User->id);
            })
            ->with(['User', 'animal.user', 'consulta', 'medicamentos.medicamento'])
            ->latest('id_receta')
            ->paginate(10);

        return view('recetas.productor.index', compact('recetas'));
    }

    public function showProductor(Receta $receta)
    {
        $User = auth()->user();

        $receta->load([
            'User',
            'animal.user',
            'consulta',
            'medicamentos.medicamento',
        ]);

        if (!$receta->animal || $receta->animal->user_id !== $User->id) {
            abort(403, 'No autorizado.');
        }

        return view('recetas.productor.show', compact('receta'));
    }

    public function downloadPDF(Receta $receta)
    {
        $User = auth()->user();

        $receta->load([
            'User',
            'animal.user',
            'consulta',
            'medicamentos.medicamento',
        ]);

        if ($receta->user_id !== $User->id && (!$receta->animal || $receta->animal->user_id !== $User->id)) {
            abort(403, 'No autorizado.');
        }

        return view('recetas.pdf', compact('receta'));
    }
}