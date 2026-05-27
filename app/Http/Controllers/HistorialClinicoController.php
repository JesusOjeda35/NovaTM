<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Consulta;
use App\Models\Animal;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    /**
     * Listar historiales
     */
    public function index()
    {
        $user = auth()->user();

        try {
            if ($user->isProfesional()) {
                // Profesional ve sus historiales creados
                $historiales = HistorialClinico::where('user_id', $user->id)
                    ->with('animal', 'User')
                    ->latest('id_historial')
                    ->paginate(10);
            } else {
                // Productor ve historiales de sus animales
                $animalesIds = $user->animales()->pluck('id_animal')->toArray();
                
                if (empty($animalesIds)) {
                    $historiales = collect([])->paginate(10);
                } else {
                    $historiales = HistorialClinico::whereIn('animales_id_animal', $animalesIds)
                        ->with('animal', 'User')
                        ->latest('id_historial')
                        ->paginate(10);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error en HistorialClinico index: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Error al cargar historiales');
        }

        return view('historiales.index', compact('historiales'));
    }

    /**
     * Crear historial desde atender cita
     */
    public function create(Request $request)
    {
        $consultaId = $request->query('consulta_id');
        
        $consulta = null;
        $animal = null;
        $productor = null;

        if ($consultaId) {
            try {
                $consulta = Consulta::with('animal', 'User')->findOrFail($consultaId);
                $animal = $consulta->animal;
                $productor = $consulta->User;
            } catch (\Exception $e) {
                \Log::error('Error al obtener consulta: ' . $e->getMessage());
                return redirect()->route('historial.index')->with('error', 'Consulta no encontrada.');
            }
        }

        return view('historiales.create', compact('consulta', 'animal', 'productor'));
    }

    /**
     * Guardar historial
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'consulta_id' => 'nullable|exists:consultas,id_consulta',
            
            // ANAMNESIS
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:1000',
            'alimentacion_dieta' => 'nullable|string|max:500',
            'enfermedades_previas' => 'nullable|string|max:500',
            'cirugias_previas' => 'nullable|string|max:500',
            'numero_partos' => 'nullable|string|max:50',
            'esquema_vacunal' => 'nullable|string|max:500',
            'ultima_desparasitacion' => 'nullable|string|max:500',
            'tratamientos_recientes' => 'nullable|string|max:500',
            'convive_otros_animales' => 'nullable|boolean',
            'cuales_animales' => 'nullable|string|max:500',
            
            // EXAMEN FÍSICO (Opcional)
            'temperatura' => 'nullable|string|max:50',
            'frecuencia_cardiaca' => 'nullable|string|max:50',
            'frecuencia_respiratoria' => 'nullable|string|max:50',
            'otros_hallazgos_fisicos' => 'nullable|string|max:500',
            
            // PROFESIONAL (Obligatorio)
            'diagnostico' => 'required|string|max:1000',
            'tratamiento' => 'required|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
            'recomendaciones_finales' => 'nullable|string|max:500',
            
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
        ]);

        $data['user_id'] = auth()->user()->id;
        $data['fecha'] = now();
        $data['sincronizado'] = 'N';
        $data['convive_otros_animales'] = $request->boolean('convive_otros_animales');

        try {
            $historial = HistorialClinico::create($data);
            
            // ========== ACTUALIZAR CONSULTA ==========
            if ($request->consulta_id) {
                try {
                    $consulta = Consulta::findOrFail($request->consulta_id);
                    $consulta->update(['estado' => 'completada', 'historial_id' => $historial->id_historial]);
                } catch (\Exception $e) {
                    \Log::error('Error al actualizar consulta: ' . $e->getMessage());
                }
            }
            
            // Limpiar caché
            \Cache::forget('historiales_' . auth()->user()->id);
            
            return redirect()->route('historial.index')
                ->with('success', 'Historial clínico creado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear historial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el historial. Intenta de nuevo.');
        }
    }

    /**
     * Ver historial
     */
    public function show(HistorialClinico $historial)
    {
        $user = auth()->user();

        // Verificar permisos
        if ($user->isProfesional()) {
            // Profesional solo ve sus historiales
            if ($historial->user_id !== $user->id) {
                return redirect()->route('historial.index')->with('error', 'No tienes permiso para ver este historial.');
            }
        } else {
            // Productor solo ve historiales de sus animales
            $animalesIds = $user->animales()->pluck('id_animal')->toArray();
            if (!in_array($historial->animales_id_animal, $animalesIds)) {
                return redirect()->route('historial.index')->with('error', 'No tienes permiso para ver este historial.');
            }
        }

        $historial->load('animal', 'User');

        return view('historiales.show', compact('historial'));
    }

    /**
     * Editar historial
     */
    public function edit(HistorialClinico $historial)
    {
        $historial->load('animal');
        return view('historiales.edit', compact('historial'));
    }

    /**
     * Actualizar historial
     */
    public function update(Request $request, HistorialClinico $historial)
    {
        $data = $request->validate([
            // ANAMNESIS
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:1000',
            'alimentacion_dieta' => 'nullable|string|max:500',
            'enfermedades_previas' => 'nullable|string|max:500',
            'cirugias_previas' => 'nullable|string|max:500',
            'numero_partos' => 'nullable|string|max:50',
            'esquema_vacunal' => 'nullable|string|max:500',
            'ultima_desparasitacion' => 'nullable|string|max:500',
            'tratamientos_recientes' => 'nullable|string|max:500',
            'convive_otros_animales' => 'nullable|boolean',
            'cuales_animales' => 'nullable|string|max:500',
            
            // EXAMEN FÍSICO (Opcional)
            'temperatura' => 'nullable|string|max:50',
            'frecuencia_cardiaca' => 'nullable|string|max:50',
            'frecuencia_respiratoria' => 'nullable|string|max:50',
            'otros_hallazgos_fisicos' => 'nullable|string|max:500',
            
            // PROFESIONAL (Obligatorio)
            'diagnostico' => 'required|string|max:1000',
            'tratamiento' => 'required|string|max:1000',
            'observaciones' => 'nullable|string|max:1000',
            'recomendaciones_finales' => 'nullable|string|max:500',
            
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
        ]);

        $data['convive_otros_animales'] = $request->boolean('convive_otros_animales');
        $data['updated_at'] = now();

        try {
            $historial->update($data);
            
            // Limpiar caché
            \Cache::forget('historiales_' . auth()->user()->id);
            
            return redirect()->route('historial.index')
                ->with('success', 'Historial clínico actualizado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar historial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el historial. Intenta de nuevo.');
        }
    }

    /**
     * Eliminar historial
     */
    /**
 * Eliminar historial
 */
    public function destroy(HistorialClinico $historial)
    {
        try {
            $historial->delete();
            
            return redirect()->route('historial.index')
                ->with('success', 'Historial clínico eliminado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar historial: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al eliminar el historial. Intenta de nuevo.');
        }
    }
}