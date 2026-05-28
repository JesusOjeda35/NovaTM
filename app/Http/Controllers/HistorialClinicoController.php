<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Consulta;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialClinicoController extends Controller
{
    /**
     * Listar historiales.
     * Ruta: historial.index
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isProfesional()) {
            /*
             * El profesional puede ver los historiales.
             * Si quieres que vea SOLO los que él creó, usa:
             * ->where('user_id', $user->id)
             *
             * Por ahora lo dejamos abierto para evitar el 403
             * y permitir ver, editar y eliminar desde la vista.
             */
            $historiales = HistorialClinico::with(['animal.user', 'User', 'consulta'])
                ->latest('id_historial')
                ->paginate(10);
        } else {
            /*
             * El productor solo ve historiales de sus animales.
             */
            $historiales = HistorialClinico::whereHas('animal', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['animal.user', 'User', 'consulta'])
                ->latest('id_historial')
                ->paginate(10);
        }

        return view('historiales.index', compact('historiales'));
    }

    /**
     * Mostrar formulario para crear historial.
     * Ruta: historial.create
     */
    public function create(Request $request)
    {
        $user = auth()->user();

        if (!$user->isProfesional()) {
            return redirect()
                ->route('historial.index')
                ->with('error', 'Solo los profesionales pueden crear historiales clínicos.');
        }

        $consultaId = $request->query('consulta_id');

        $consulta = null;
        $animal = null;
        $productor = null;

        if ($consultaId) {
            $consulta = Consulta::with(['animal.user', 'User'])
                ->where('id_consulta', $consultaId)
                ->first();

            if ($consulta) {
                $animal = $consulta->animal;
                $productor = $animal ? $animal->user : null;
            }
        }

        return view('historiales.create', compact('consulta', 'animal', 'productor'));
    }

    /**
     * Guardar historial.
     * Ruta: historial.store
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user->isProfesional()) {
            return redirect()
                ->route('historial.index')
                ->with('error', 'Solo los profesionales pueden crear historiales clínicos.');
        }

        $validated = $request->validate([
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'consulta_id' => 'nullable|exists:consultas,id_consulta',
            'fecha' => 'nullable|date',

            'tipo_evento' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:5000',
            'diagnostico' => 'required|string|max:5000',
            'tratamiento' => 'required|string|max:5000',

            'alimentacion_dieta' => 'nullable|string|max:5000',
            'enfermedades_previas' => 'nullable|string|max:5000',
            'cirugias_previas' => 'nullable|string|max:5000',
            'numero_partos' => 'nullable|string|max:255',
            'esquema_vacunal' => 'nullable|string|max:5000',
            'ultima_desparasitacion' => 'nullable|string|max:5000',
            'tratamientos_recientes' => 'nullable|string|max:5000',
            'convive_otros_animales' => 'nullable',
            'cuales_animales' => 'nullable|string|max:5000',

            'temperatura' => 'nullable|string|max:255',
            'frecuencia_cardiaca' => 'nullable|string|max:255',
            'frecuencia_respiratoria' => 'nullable|string|max:255',
            'otros_hallazgos_fisicos' => 'nullable|string|max:5000',

            'observaciones' => 'nullable|string|max:5000',
            'recomendaciones_finales' => 'nullable|string|max:5000',
        ], [
            'animales_id_animal.required' => 'Debes seleccionar un animal.',
            'animales_id_animal.exists' => 'El animal seleccionado no existe.',
            'tipo_evento.required' => 'El tipo de evento es obligatorio.',
            'diagnostico.required' => 'El diagnóstico es obligatorio.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
        ]);

        DB::beginTransaction();

        try {
            $historial = HistorialClinico::create([
                'user_id' => $user->id,
                'animales_id_animal' => $validated['animales_id_animal'],
                'consulta_id' => $validated['consulta_id'] ?? null,
                'fecha' => $validated['fecha'] ?? now(),

                'tipo_evento' => $validated['tipo_evento'],
                'descripcion' => $validated['descripcion'] ?? null,
                'diagnostico' => $validated['diagnostico'],
                'tratamiento' => $validated['tratamiento'],

                'alimentacion_dieta' => $validated['alimentacion_dieta'] ?? null,
                'enfermedades_previas' => $validated['enfermedades_previas'] ?? null,
                'cirugias_previas' => $validated['cirugias_previas'] ?? null,
                'numero_partos' => $validated['numero_partos'] ?? null,
                'esquema_vacunal' => $validated['esquema_vacunal'] ?? null,
                'ultima_desparasitacion' => $validated['ultima_desparasitacion'] ?? null,
                'tratamientos_recientes' => $validated['tratamientos_recientes'] ?? null,
                'convive_otros_animales' => $request->has('convive_otros_animales'),
                'cuales_animales' => $validated['cuales_animales'] ?? null,

                'temperatura' => $validated['temperatura'] ?? null,
                'frecuencia_cardiaca' => $validated['frecuencia_cardiaca'] ?? null,
                'frecuencia_respiratoria' => $validated['frecuencia_respiratoria'] ?? null,
                'otros_hallazgos_fisicos' => $validated['otros_hallazgos_fisicos'] ?? null,

                'observaciones' => $validated['observaciones'] ?? null,
                'recomendaciones_finales' => $validated['recomendaciones_finales'] ?? null,

                'archivos_adjuntos' => null,
                'firma_digital' => null,
                'sincronizado' => 'N',
            ]);

            if (!empty($validated['consulta_id'])) {
                Consulta::where('id_consulta', $validated['consulta_id'])
                    ->update([
                        'historial_id' => $historial->id_historial,
                    ]);
            }

            DB::commit();

            return redirect()
                ->route('historial.show', $historial->id_historial)
                ->with('success', 'Historial clínico creado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear el historial: ' . $e->getMessage());
        }
    }

    /**
     * Ver historial completo.
     * Ruta: historial.show
     */
    public function show($id)
    {
        $user = auth()->user();

        $historial = HistorialClinico::with(['animal.user', 'User', 'consulta'])
            ->where('id_historial', $id)
            ->firstOrFail();

        /*
         * Profesional puede ver.
         * Productor solo si el animal es suyo.
         */
        if (!$user->isProfesional()) {
            if (!$historial->animal || $historial->animal->user_id !== $user->id) {
                abort(403, 'No autorizado.');
            }
        }

        return view('historiales.show', compact('historial'));
    }

    /**
     * Mostrar formulario de edición.
     * Ruta: historial.edit
     */
    public function edit($id)
    {
        $user = auth()->user();

        if (!$user->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $historial = HistorialClinico::with(['animal.user', 'User', 'consulta'])
            ->where('id_historial', $id)
            ->firstOrFail();

        return view('historiales.edit', compact('historial'));
    }

    /**
     * Actualizar historial.
     * Ruta: historial.update
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $historial = HistorialClinico::where('id_historial', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'tipo_evento' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:5000',
            'diagnostico' => 'required|string|max:5000',
            'tratamiento' => 'required|string|max:5000',

            'alimentacion_dieta' => 'nullable|string|max:5000',
            'enfermedades_previas' => 'nullable|string|max:5000',
            'cirugias_previas' => 'nullable|string|max:5000',
            'numero_partos' => 'nullable|string|max:255',
            'esquema_vacunal' => 'nullable|string|max:5000',
            'ultima_desparasitacion' => 'nullable|string|max:5000',
            'tratamientos_recientes' => 'nullable|string|max:5000',
            'convive_otros_animales' => 'nullable',
            'cuales_animales' => 'nullable|string|max:5000',

            'temperatura' => 'nullable|string|max:255',
            'frecuencia_cardiaca' => 'nullable|string|max:255',
            'frecuencia_respiratoria' => 'nullable|string|max:255',
            'otros_hallazgos_fisicos' => 'nullable|string|max:5000',

            'observaciones' => 'nullable|string|max:5000',
            'recomendaciones_finales' => 'nullable|string|max:5000',
        ], [
            'tipo_evento.required' => 'El tipo de evento es obligatorio.',
            'diagnostico.required' => 'El diagnóstico es obligatorio.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
        ]);

        DB::beginTransaction();

        try {
            $historial->update([
                'tipo_evento' => $validated['tipo_evento'],
                'descripcion' => $validated['descripcion'] ?? null,
                'diagnostico' => $validated['diagnostico'],
                'tratamiento' => $validated['tratamiento'],

                'alimentacion_dieta' => $validated['alimentacion_dieta'] ?? null,
                'enfermedades_previas' => $validated['enfermedades_previas'] ?? null,
                'cirugias_previas' => $validated['cirugias_previas'] ?? null,
                'numero_partos' => $validated['numero_partos'] ?? null,
                'esquema_vacunal' => $validated['esquema_vacunal'] ?? null,
                'ultima_desparasitacion' => $validated['ultima_desparasitacion'] ?? null,
                'tratamientos_recientes' => $validated['tratamientos_recientes'] ?? null,
                'convive_otros_animales' => $request->has('convive_otros_animales'),
                'cuales_animales' => $validated['cuales_animales'] ?? null,

                'temperatura' => $validated['temperatura'] ?? null,
                'frecuencia_cardiaca' => $validated['frecuencia_cardiaca'] ?? null,
                'frecuencia_respiratoria' => $validated['frecuencia_respiratoria'] ?? null,
                'otros_hallazgos_fisicos' => $validated['otros_hallazgos_fisicos'] ?? null,

                'observaciones' => $validated['observaciones'] ?? null,
                'recomendaciones_finales' => $validated['recomendaciones_finales'] ?? null,
                'sincronizado' => 'N',
            ]);

            DB::commit();

            return redirect()
                ->route('historial.show', $historial->id_historial)
                ->with('success', 'Historial clínico actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar el historial: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar historial.
     * Ruta: historial.destroy
     */
    public function destroy($id)
    {
        $user = auth()->user();

        if (!$user->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $historial = HistorialClinico::where('id_historial', $id)
            ->firstOrFail();

        DB::beginTransaction();

        try {
            Consulta::where('historial_id', $historial->id_historial)
                ->update([
                    'historial_id' => null,
                ]);

            $historial->delete();

            DB::commit();

            return redirect()
                ->route('historial.index')
                ->with('success', 'Historial clínico eliminado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Error al eliminar el historial: ' . $e->getMessage());
        }
    }
}