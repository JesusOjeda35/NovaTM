<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Medicamento;
use App\Models\RecetaMedicamentos;
use App\Models\User;
use App\Models\Animal;
use App\Models\Consulta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    // ========== VISTAS PROFESIONAL ==========
    
    public function indexProfesional()
    {
        $User = auth()->user();
        $recetas = Receta::where('user_id', $User->id)
            ->with('animal', 'consulta', 'medicamentos')
            ->latest('id_receta')
            ->paginate(10);
        return view('recetas.profesional.index', compact('recetas'));
    }

    public function create()
    {
        $User = auth()->user();
        $consultas = Consulta::where('estado', 'atendida')
            ->with('animal', 'User')
            ->orderBy('id_consulta', 'desc')
            ->get();
        $medicamentos = Medicamento::orderBy('categoria')->orderBy('nombre')->get();
        return view('recetas.profesional.create', compact('consultas', 'medicamentos'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $validated = $request->validate([
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'diagnostico' => 'required|string|max:1000',
            'indicaciones_generales' => 'nullable|string|max:1000',
            'notas_adicionales' => 'nullable|string|max:1000',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamentos_id_medicamento' => 'required|exists:medicamentos,id_medicamento',
            'medicamentos.*.dosis' => 'required|string|max:100',
            'medicamentos.*.frecuencia' => 'required|string|max:50',
            'medicamentos.*.duracion' => 'required|string|max:50',
            'medicamentos.*.via_administracion' => 'nullable|string|max:50',
        ]);

        $consulta = Consulta::find($validated['consultas_id_consulta']);

        // Crear receta
        $receta = Receta::create([
            'user_id' => $User->id,
            'animales_id_animal' => $consulta->animales_id_animal,
            'consultas_id_consulta' => $consulta->id_consulta,
            'diagnostico' => $validated['diagnostico'],
            'indicaciones_generales' => $validated['indicaciones_generales'],
            'notas_adicionales' => $validated['notas_adicionales'],
            'fecha_emision' => now(),
            'estado' => 'activa',
            'sincronizado' => 'N',
        ]);

        // Agregar medicamentos
        foreach ($validated['medicamentos'] as $med) {
            $medicamento = Medicamento::find($med['medicamentos_id_medicamento']);
            RecetaMedicamentos::create([
                'recetas_id' => $receta->id_receta,
                'medicamentos_id_medicamento' => $med['medicamentos_id_medicamento'],
                'nombre_medicamento' => $medicamento->nombre,
                'dosis' => $med['dosis'],
                'via_administracion' => $med['via_administracion'] ?? $medicamento->via_administracion,
                'frecuencia' => $med['frecuencia'],
                'duracion' => $med['duracion'],
            ]);
        }

        return redirect()->route('profesional.recetas')->with('success', 'Receta creada correctamente.');
    }

    public function showProfesional(Receta $receta)
    {
        // Verificar que sea el profesional que creó la receta
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $receta->load('animal', 'consulta', 'medicamentos.medicamento', 'User');
        return view('recetas.profesional.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        // Solo el profesional que creó la receta
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $medicamentos = Medicamento::orderBy('categoria')->orderBy('nombre')->get();
        $receta->load('medicamentos.medicamento');
        return view('recetas.profesional.edit', compact('receta', 'medicamentos'));
    }

    public function update(Request $request, Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $validated = $request->validate([
            'diagnostico' => 'required|string|max:1000',
            'indicaciones_generales' => 'nullable|string|max:1000',
            'notas_adicionales' => 'nullable|string|max:1000',
            'medicamentos' => 'required|array|min:1',
            'medicamentos.*.medicamentos_id_medicamento' => 'required|exists:medicamentos,id_medicamento',
            'medicamentos.*.dosis' => 'required|string|max:100',
            'medicamentos.*.frecuencia' => 'required|string|max:50',
            'medicamentos.*.duracion' => 'required|string|max:50',
            'medicamentos.*.via_administracion' => 'nullable|string|max:50',
        ]);

        $receta->update([
            'diagnostico' => $validated['diagnostico'],
            'indicaciones_generales' => $validated['indicaciones_generales'],
            'notas_adicionales' => $validated['notas_adicionales'],
        ]);

        // Eliminar medicamentos antiguos
        RecetaMedicamentos::where('recetas_id', $receta->id_receta)->delete();

        // Agregar medicamentos nuevos
        foreach ($validated['medicamentos'] as $med) {
            $medicamento = Medicamento::find($med['medicamentos_id_medicamento']);
            RecetaMedicamentos::create([
                'recetas_id' => $receta->id_receta,
                'medicamentos_id_medicamento' => $med['medicamentos_id_medicamento'],
                'nombre_medicamento' => $medicamento->nombre,
                'dosis' => $med['dosis'],
                'via_administracion' => $med['via_administracion'] ?? $medicamento->via_administracion,
                'frecuencia' => $med['frecuencia'],
                'duracion' => $med['duracion'],
            ]);
        }

        return redirect()->route('profesional.recetas')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        if ($receta->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        RecetaMedicamentos::where('recetas_id', $receta->id_receta)->delete();
        $receta->delete();

        return redirect()->route('profesional.recetas')->with('success', 'Receta eliminada correctamente.');
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
        ->with('User', 'animal', 'medicamentos')
        ->latest('id_receta')
        ->paginate(10);
        
        return view('recetas.productor.index', compact('recetas'));
    }

    public function showProductor(Receta $receta)
    {
        $User = auth()->user();
        $animal = $receta->animal;

        // Verificar que el productor sea dueño del animal
        if ($animal->user_id !== $User->id) {
            abort(403, 'No autorizado.');
        }

        $receta->load('User', 'animal', 'medicamentos.medicamento', 'consulta');
        return view('recetas.productor.show', compact('receta'));
    }

    public function downloadPDF(Receta $receta)
    {
        $User = auth()->user();
        
        // Verificar acceso (productor o profesional)
        if ($receta->user_id !== $User->id && $receta->animal->user_id !== $User->id) {
            abort(403, 'No autorizado.');
        }

        $receta->load('User', 'animal', 'medicamentos.medicamento', 'consulta');
        
        // Aquí irá la lógica del PDF
        // Por ahora retornamos una vista
        return view('recetas.pdf', compact('receta'));
    }
}