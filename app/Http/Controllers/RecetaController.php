<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Usuario;
use App\Models\Animal;
use App\Models\Consulta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with('usuario', 'animal', 'consulta')->latest('id_receta')->paginate(10);
        return view('recetas.index', compact('recetas'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();
        $consultas = Consulta::orderBy('id_consulta')->get();

        return view('recetas.create', compact('usuarios', 'animales', 'consultas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'fecha_emision' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'firma_electronica' => 'nullable|string|max:100',
            'estado' => 'required|string|max:15',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Receta::create($data);

        return redirect()->route('recetas.index')->with('success', 'Receta creada correctamente.');
    }

    public function show(Receta $receta)
    {
        $receta->load('usuario', 'animal', 'consulta', 'medicamentos');
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();
        $consultas = Consulta::orderBy('id_consulta')->get();

        return view('recetas.edit', compact('receta', 'usuarios', 'animales', 'consultas'));
    }

    public function update(Request $request, Receta $receta)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'fecha_emision' => 'nullable|date',
            'fecha_vencimiento' => 'nullable|date',
            'firma_electronica' => 'nullable|string|max:100',
            'estado' => 'required|string|max:15',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $receta->update($data);

        return redirect()->route('recetas.index')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        $receta->delete();

        return redirect()->route('recetas.index')->with('success', 'Receta eliminada correctamente.');
    }
}