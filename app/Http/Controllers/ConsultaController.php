<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Usuario;
use App\Models\Animal;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('usuario', 'animal')->latest('id_consulta')->paginate(10);
        return view('consultas.index', compact('consultas'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();

        return view('consultas.create', compact('usuarios', 'animales'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'tipo_consulta' => 'required|string|max:20',
            'estado' => 'required|string|max:20',
            'fecha_solicitud' => 'nullable|date',
            'fecha_atencion' => 'nullable|date',
            'motivo' => 'nullable|string|max:300',
            'urgencia' => 'nullable|string|max:15',
            'diagnostico_resumido' => 'nullable|string|max:200',
            'recomendaciones' => 'nullable|string|max:300',
            'requiere_presencial' => 'nullable|string|size:1',
            'id_consulta_referencia' => 'nullable|integer',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Consulta::create($data);

        return redirect()->route('consultas.index')->with('success', 'Consulta creada correctamente.');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load('usuario', 'animal', 'mensajes', 'recetas');
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $animales = Animal::orderBy('nombre')->get();

        return view('consultas.edit', compact('consulta', 'usuarios', 'animales'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'tipo_consulta' => 'required|string|max:20',
            'estado' => 'required|string|max:20',
            'fecha_solicitud' => 'nullable|date',
            'fecha_atencion' => 'nullable|date',
            'motivo' => 'nullable|string|max:300',
            'urgencia' => 'nullable|string|max:15',
            'diagnostico_resumido' => 'nullable|string|max:200',
            'recomendaciones' => 'nullable|string|max:300',
            'requiere_presencial' => 'nullable|string|size:1',
            'id_consulta_referencia' => 'nullable|integer',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $consulta->update($data);

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada correctamente.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();

        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada correctamente.');
    }
}