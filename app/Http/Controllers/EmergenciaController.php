<?php

namespace App\Http\Controllers;

use App\Models\Emergencia;
use App\Models\Usuario;
use App\Models\Animal;
use Illuminate\Http\Request;

class EmergenciaController extends Controller
{
    public function index()
    {
        $emergencias = Emergencia::with('usuarioReporta', 'usuarioAtiende', 'animal')->latest('id_emergencia')->paginate(10);
        return view('emergencias.index', compact('emergencias'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();

        return view('emergencias.create', compact('usuarios', 'animales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'usuarios_id2' => 'nullable|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'fecha_reporte' => 'nullable|date',
            'sintomas_graves' => 'nullable|string|max:300',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'direccion_texto' => 'nullable|string|max:200',
            'triage_resultado' => 'nullable|string|max:30',
            'estado' => 'required|string|max:20',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Emergencia::create($data);

        return redirect()->route('emergencias.index')->with('success', 'Emergencia creada correctamente.');
    }

    public function show(Emergencia $emergencia)
    {
        $emergencia->load('usuarioReporta', 'usuarioAtiende', 'animal');
        return view('emergencias.show', compact('emergencia'));
    }

    public function edit(Emergencia $emergencia)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();

        return view('emergencias.edit', compact('emergencia', 'usuarios', 'animales'));
    }

    public function update(Request $request, Emergencia $emergencia)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'usuarios_id2' => 'nullable|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'fecha_reporte' => 'nullable|date',
            'sintomas_graves' => 'nullable|string|max:300',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'direccion_texto' => 'nullable|string|max:200',
            'triage_resultado' => 'nullable|string|max:30',
            'estado' => 'required|string|max:20',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $emergencia->update($data);

        return redirect()->route('emergencias.index')->with('success', 'Emergencia actualizada correctamente.');
    }

    public function destroy(Emergencia $emergencia)
    {
        $emergencia->delete();

        return redirect()->route('emergencias.index')->with('success', 'Emergencia eliminada correctamente.');
    }
}