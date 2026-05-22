<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\User;
use App\Models\Animal;
use App\Models\Consulta;
use Illuminate\Http\Request;

class RecetaController extends Controller
{
    public function index()
    {
        $recetas = Receta::with('User', 'animal', 'consulta')->latest('id_receta')->paginate(10);
        return view('recetas.index', compact('recetas'));
    }

    public function misRecetas()
    {
        $User = auth()->user();
        $recetas = Receta::where('Users_id', $User->id)
            ->with('animal', 'medicamentos')
            ->latest('id_receta')
            ->paginate(10);
        return view('recetas.mis-recetas', compact('recetas'));
    }

    public function create()
    {
        $consultas = Consulta::where('estado', 'atendida')
            ->orderBy('id_consulta')
            ->get();
        return view('recetas.create', compact('consultas'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'fecha_vencimiento' => 'required|date',
            'instrucciones' => 'nullable|string|max:300',
        ]);

        $consulta = Consulta::find($data['consultas_id_consulta']);

        $data['Users_id'] = $User->id;
        $data['animales_id_animal'] = $consulta->animales_id_animal;
        $data['fecha_emision'] = now();
        $data['estado'] = 'activa';
        $data['sincronizado'] = 'N';

        Receta::create($data);

        return redirect()->route('profesional.recetas')->with('success', 'Receta creada correctamente.');
    }

    public function show(Receta $receta)
    {
        $receta->load('User', 'animal', 'consulta', 'medicamentos');
        return view('recetas.show', compact('receta'));
    }

    public function edit(Receta $receta)
    {
        // Solo el profesional que creo la receta puede editarla
        if ($receta->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        return view('recetas.edit', compact('receta'));
    }

    public function update(Request $request, Receta $receta)
    {
        // Solo el profesional que creo la receta puede actualizar
        if ($receta->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $data = $request->validate([
            'fecha_vencimiento' => 'required|date',
            'instrucciones' => 'nullable|string|max:300',
            'estado' => 'required|string|max:15',
        ]);

        $receta->update($data);

        return redirect()->route('profesional.recetas')->with('success', 'Receta actualizada correctamente.');
    }

    public function destroy(Receta $receta)
    {
        // Solo el profesional que creo la receta puede eliminarla
        if ($receta->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $receta->delete();

        return redirect()->route('profesional.recetas')->with('success', 'Receta eliminada correctamente.');
    }
}