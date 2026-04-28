<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::with('usuario')->latest('id_animal')->paginate(10);
        return view('animales.index', compact('animales'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        return view('animales.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:50',
            'identificacion_propia' => 'nullable|string|max:30',
            'especie' => 'required|string|max:30',
            'raza' => 'nullable|string|max:30',
            'edad' => 'nullable|string|max:20',
            'peso' => 'nullable|numeric',
            'estado_salud' => 'nullable|string|max:20',
            'foto_url' => 'nullable|string|max:200',
            'fecha_registro' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Animal::create($data);

        return redirect()->route('animales.index')->with('success', 'Animal creado correctamente.');
    }

    public function show(Animal $animal)
    {
        $animal->load('usuario', 'consultas', 'historialesClinicos', 'recetas');
        return view('animales.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        return view('animales.edit', compact('animal', 'usuarios'));
    }

    public function update(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:50',
            'identificacion_propia' => 'nullable|string|max:30',
            'especie' => 'required|string|max:30',
            'raza' => 'nullable|string|max:30',
            'edad' => 'nullable|string|max:20',
            'peso' => 'nullable|numeric',
            'estado_salud' => 'nullable|string|max:20',
            'foto_url' => 'nullable|string|max:200',
            'fecha_registro' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $animal->update($data);

        return redirect()->route('animales.index')->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();

        return redirect()->route('animales.index')->with('success', 'Animal eliminado correctamente.');
    }
}