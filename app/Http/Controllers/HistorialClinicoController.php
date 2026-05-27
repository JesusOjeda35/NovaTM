<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Consulta;
use App\Models\Animal;
use App\Models\Notificaciones;
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
                $historiales = HistorialClinico::where('user_id', $user->id)
                    ->with('animal', 'User')
                    ->latest('id_historial')
                    ->paginate(10);
            } else {
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
     * Crear historial
     */
    public function create(Request $request)
    {
        if (!auth()->user()->isProfesional()) {
            return redirect()->to('/historiales')->with('error', 'Solo profesionales pueden crear historiales.');
        }

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
                return redirect()->to('/historiales')->with('error', 'Consulta no encontrada.');
            }
        }

        return view('historiales.create', compact('consulta', 'animal', 'productor'));
    }

    /**
     * Guardar historial
     */
    public function store(Request $request)
    {
        \Log::info('🔥 INICIANDO STORE');
        \Log::info('Request data:', $request->all());

        if (!auth()->check()) {
            \Log::error('❌ No autenticado');
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        if (!auth()->user()->isProfesional()) {
            \Log::error('❌ No es profesional', ['user_id' => auth()->user()->id]);
            return redirect()->to('/historiales')->with('error', 'Solo profesionales pueden crear historiales.');
        }

        try {
            \Log::info('✅ Validando datos...');
            
            $data = $request->validate([
                'animales_id_animal' => 'required|exists:animales,id_animal',
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
                'temperatura' => 'nullable|string|max:50',
                'frecuencia_cardiaca' => 'nullable|string|max:50',
                'frecuencia_respiratoria' => 'nullable|string|max:50',
                'otros_hallazgos_fisicos' => 'nullable|string|max:500',
                'diagnostico' => 'required|string|max:1000',
                'tratamiento' => 'required|string|max:1000',
                'observaciones' => 'nullable|string|max:1000',
                'recomendaciones_finales' => 'nullable|string|max:500',
            ]);

            \Log::info('✅ Datos validados', ['keys' => array_keys($data)]);

            $data['user_id'] = auth()->user()->id;
            $data['fecha'] = now();
            $data['sincronizado'] = 'N';
            $data['convive_otros_animales'] = $request->boolean('convive_otros_animales') ? '1' : '0';

            \Log::info('✅ Datos preparados para guardar', $data);

            // Crear historial
            $historial = HistorialClinico::create($data);
            
            \Log::info('✅✅✅ HISTORIAL CREADO EXITOSAMENTE', ['id_historial' => $historial->id_historial]);

            // Obtener animal y productor
            $animal = Animal::findOrFail($data['animales_id_animal']);
            $productor = $animal->user;

            \Log::info('✅ Animal encontrado', ['id_animal' => $animal->id_animal, 'nombre' => $animal->nombre]);

            // Notificar al productor
            if ($productor) {
                Notificaciones::create([
                    'Users_id' => $productor->id,
                    'tipo' => 'historial_creado',
                    'contenido' => "Se ha creado un nuevo historial clínico para tu animal '{$animal->nombre}'",
                    'leido' => 'N',
                    'fecha_creacion' => now(),
                    'sincronizado' => 'N',
                ]);
                \Log::info('✅ Notificación creada para productor', ['productor_id' => $productor->id]);
            }

            \Log::info('✅ REDIRIGIENDO A /historiales');
            
            return redirect()->to('/historiales')->with('success', "✅ ¡Historial creado exitosamente para '{$animal->nombre}'!");

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ ERROR DE VALIDACIÓN', $e->errors());
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('❌ ERROR GENERAL', [
                'mensaje' => $e->getMessage(),
                'archivo' => $e->getFile(),
                'linea' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ver historial
     */
    public function show(HistorialClinico $historial)
    {
        $user = auth()->user();

        if ($user->isProfesional()) {
            if ($historial->user_id !== $user->id) {
                abort(403);
            }
        } else {
            $animalesIds = $user->animales()->pluck('id_animal')->toArray();
            if (!in_array($historial->animales_id_animal, $animalesIds)) {
                abort(403);
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
        if (!auth()->check() || $historial->user_id !== auth()->user()->id) {
            abort(403);
        }

        $historial->load('animal');
        return view('historiales.edit', compact('historial'));
    }

    /**
     * Actualizar historial
     */
    public function update(Request $request, HistorialClinico $historial)
    {
        if (!auth()->check() || $historial->user_id !== auth()->user()->id) {
            abort(403);
        }

        try {
            $data = $request->validate([
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
                'temperatura' => 'nullable|string|max:50',
                'frecuencia_cardiaca' => 'nullable|string|max:50',
                'frecuencia_respiratoria' => 'nullable|string|max:50',
                'otros_hallazgos_fisicos' => 'nullable|string|max:500',
                'diagnostico' => 'required|string|max:1000',
                'tratamiento' => 'required|string|max:1000',
                'observaciones' => 'nullable|string|max:1000',
                'recomendaciones_finales' => 'nullable|string|max:500',
            ]);

            $data['convive_otros_animales'] = $request->boolean('convive_otros_animales') ? '1' : '0';

            $historial->update($data);

            return redirect()->to('/historiales')->with('success', 'Historial actualizado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar historial: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Eliminar historial
     */
    public function destroy(HistorialClinico $historial)
    {
        if (!auth()->check() || $historial->user_id !== auth()->user()->id) {
            abort(403);
        }

        try {
            $historial->delete();
            return redirect()->to('/historiales')->with('success', 'Historial eliminado exitosamente');
        } catch (\Exception $e) {
            \Log::error('Error al eliminar historial: ' . $e->getMessage());
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}