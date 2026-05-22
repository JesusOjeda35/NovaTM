<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\User;
use App\Models\Animal;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index()
    {
        // Solo profesionales ven todos los historiales
        if (!auth()->user()->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $historiales = HistorialClinico::with('User', 'animal')->latest('id_historial')->paginate(10);
        return view('historiales.index', compact('historiales'));
    }

    public function create()
    {
        $animales = Animal::orderBy('nombre')->get();
        return view('historiales.create', compact('animales'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:500',
            'diagnostico' => 'nullable|string|max:200',
            'tratamiento' => 'nullable|string|max:300',
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
        ]);

        $data['Users_id'] = $User->id;
        $data['fecha'] = now();
        $data['sincronizado'] = 'N';

        HistorialClinico::create($data);

        return redirect()->route('profesional.historiales')->with('success', 'Historial creado correctamente.');
    }

    public function show(HistorialClinico $historial)
    {
        $historial->load('User', 'animal');
        return view('historiales.show', compact('historial'));
    }

    public function edit(HistorialClinico $historial)
    {
        return view('historiales.edit', compact('historial'));
    }

    public function update(Request $request, HistorialClinico $historial)
    {
        $data = $request->validate([
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:500',
            'diagnostico' => 'nullable|string|max:200',
            'tratamiento' => 'nullable|string|max:300',
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
        ]);

        $historial->update($data);

        return redirect()->route('profesional.historiales')->with('success', 'Historial actualizado correctamente.');
    }

    public function destroy(HistorialClinico $historial)
    {
        $historial->delete();

        return redirect()->route('profesional.historiales')->with('success', 'Historial eliminado correctamente.');
    }
}