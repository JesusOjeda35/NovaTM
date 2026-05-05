<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Usuario;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index()
    {
        $animales = Animal::with('usuario')->where('usuarios_id', auth()->user()->id)->latest('id_animal')->paginate(10);
        return view('animales.index', compact('animales'));
    }

    public function create()
    {
        return view('animales.create');
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
            'foto_url' => 'nullable|image|mimes:jpeg,png|max:5120',
            'fecha_registro' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        // Guardar la foto si existe
        if ($request->hasFile('foto_url')) {
            $file = $request->file('foto_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/animales'), $filename);
            $data['foto_url'] = 'uploads/animales/' . $filename;
        }

        $animal = Animal::create($data);

        return redirect()->route('animal.show', $animal->id_animal)->with('success', 'Animal creado correctamente.');
    }

    public function show(Animal $animal)
    {
        // Verificar que el animal pertenece al usuario autenticado
        if ($animal->usuarios_id !== auth()->user()->id) {
            abort(403, 'No autorizado para ver este animal.');
        }

        $animal->load('usuario', 'consultas', 'historialesClinicos', 'recetas');
        return view('animales.success', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        // Verificar que el animal pertenece al usuario autenticado
        if ($animal->usuarios_id !== auth()->user()->id) {
            abort(403, 'No autorizado para editar este animal.');
        }

        $usuarios = Usuario::orderBy('nombre_completo')->get();
        return view('animales.edit', compact('animal', 'usuarios'));
    }

    public function update(Request $request, Animal $animal)
    {
        // Verificar que el animal pertenece al usuario autenticado
        if ($animal->usuarios_id !== auth()->user()->id) {
            abort(403, 'No autorizado para actualizar este animal.');
        }

        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'nombre' => 'required|string|max:50',
            'identificacion_propia' => 'nullable|string|max:30',
            'especie' => 'required|string|max:30',
            'raza' => 'nullable|string|max:30',
            'edad' => 'nullable|string|max:20',
            'peso' => 'nullable|numeric',
            'estado_salud' => 'nullable|string|max:20',
            'foto_url' => 'nullable|image|mimes:jpeg,png|max:5120',
            'fecha_registro' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        // Guardar la foto si existe
        if ($request->hasFile('foto_url')) {
            // Eliminar foto anterior si existe
            if ($animal->foto_url && file_exists(public_path($animal->foto_url))) {
                unlink(public_path($animal->foto_url));
            }

            $file = $request->file('foto_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/animales'), $filename);
            $data['foto_url'] = 'uploads/animales/' . $filename;
        }

        $animal->update($data);

        return redirect()->route('productor.animales')->with('success', 'Animal actualizado correctamente.');
    }

    public function destroy(Animal $animal)
    {
        // Verificar que el animal pertenece al usuario autenticado
        if ($animal->usuarios_id !== auth()->user()->id) {
            abort(403, 'No autorizado para eliminar este animal.');
        }

        // Eliminar foto si existe
        if ($animal->foto_url && file_exists(public_path($animal->foto_url))) {
            unlink(public_path($animal->foto_url));
        }

        $animal->delete();

        return redirect()->route('productor.animales')->with('success', 'Animal eliminado correctamente.');
    }
}