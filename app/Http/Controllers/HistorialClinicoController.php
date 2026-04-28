<?php

namespace App\Http\Controllers;

use App\Models\HistorialClinico;
use App\Models\Usuario;
use App\Models\Animal;
use Illuminate\Http\Request;

class HistorialClinicoController extends Controller
{
    public function index()
    {
        $historiales = HistorialClinico::with('usuario', 'animal')->latest('id_historial')->paginate(10);
        return view('historiales.index', compact('historiales'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();
        return view('historiales.create', compact('usuarios', 'animales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'fecha' => 'nullable|date',
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:500',
            'diagnostico' => 'nullable|string|max:200',
            'tratamiento' => 'nullable|string|max:300',
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        HistorialClinico::create($data);

        return redirect()->route('historiales.index')->with('success', 'Historial creado correctamente.');
    }

    public function show(HistorialClinico $historial)
    {
        $historial->load('usuario', 'animal');
        return view('historiales.show', compact('historial'));
    }

    public function edit(HistorialClinico $historial)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();
        return view('historiales.edit', compact('historial', 'usuarios', 'animales'));
    }

    public function update(Request $request, HistorialClinico $historial)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'fecha' => 'nullable|date',
            'tipo_evento' => 'required|string|max:30',
            'descripcion' => 'nullable|string|max:500',
            'diagnostico' => 'nullable|string|max:200',
            'tratamiento' => 'nullable|string|max:300',
            'archivos_adjuntos' => 'nullable|string',
            'firma_digital' => 'nullable|string|max:100',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $historial->update($data);

        return redirect()->route('historiales.index')->with('success', 'Historial actualizado correctamente.');
    }

    public function destroy(HistorialClinico $historial)
    {
        $historial->delete();

        return redirect()->route('historiales.index')->with('success', 'Historial eliminado correctamente.');
    }
}