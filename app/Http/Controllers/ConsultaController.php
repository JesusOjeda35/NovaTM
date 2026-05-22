<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\User;
use App\Models\Animal;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index()
    {
        // Si es profesional, mostrar disponibilidades
        if (auth()->user()->isProfesional()) {
            $disponibilidades = Disponibilidad::where('user_id', auth()->user()->id)
                ->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->get();
            return view('consultas.index-profesional', compact('disponibilidades'));
        }

        // Si es productor, mostrar consultas
        $consultas = Consulta::with('User', 'animal')->latest('id_consulta')->paginate(10);
        return view('consultas.index', compact('consultas'));
    }

    public function misConsultas()
    {
        $User = auth()->user();
        $consultas = Consulta::where('user_id', $User->id)
            ->with('animal', 'mensajes')
            ->latest('id_consulta')
            ->paginate(10);
        return view('consultas.mis-consultas', compact('consultas'));
    }

    public function create()
    {
        $animales = Animal::orderBy('nombre')->get();
        return view('consultas.create', compact('animales'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'tipo_consulta' => 'required|string|max:20',
            'motivo' => 'nullable|string|max:300',
            'urgencia' => 'nullable|string|max:15',
        ]);

        $data['user_id'] = $User->id;
        $data['estado'] = 'pendiente';
        $data['fecha_solicitud'] = now();
        $data['sincronizado'] = 'N';

        Consulta::create($data);

        return redirect()->route('productor.consultas')->with('success', 'Consulta creada correctamente.');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load('User', 'animal', 'mensajes', 'recetas');
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        // Solo profesionales pueden editar
        if (!auth()->user()->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        return view('consultas.edit', compact('consulta'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        // Solo profesionales pueden actualizar
        if (!auth()->user()->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $data = $request->validate([
            'estado' => 'required|string|max:20',
            'diagnostico_resumido' => 'nullable|string|max:200',
            'recomendaciones' => 'nullable|string|max:300',
            'requiere_presencial' => 'nullable|string|size:1',
        ]);

        $data['fecha_atencion'] = now();

        $consulta->update($data);

        return redirect()->route('profesional.consultas')->with('success', 'Consulta actualizada correctamente.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();

        return redirect()->route('profesional.consultas')->with('success', 'Consulta eliminada correctamente.');
    }
}