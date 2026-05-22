<?php

namespace App\Http\Controllers;
use App\Models\Animal;
use App\Models\Disponibilidad;
use Illuminate\Http\Request;

class DisponibilidadController extends Controller
{
    public function index()
    {
        $disponibilidades = Disponibilidad::where('user_id', auth()->user()->id)
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();
        
        return view('disponibilidades.index', compact('disponibilidades'));
    }

    public function create()
    {
    $animales = Animal::orderBy('nombre')->get();
    $disponibilidades = Disponibilidad::where('user_id', auth()->id())
        ->orderBy('dia_semana')
        ->get();
    
    return view('disponibilidades.create', compact('animales', 'disponibilidades'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'especialidad' => 'required|string|max:50',
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'precio_consulta' => 'required|numeric|min:0',
        ]);

        $data['user_id'] = auth()->user()->id;

        Disponibilidad::create($data);

        return redirect()->route('disponibilidades.index')->with('success', 'Disponibilidad creada correctamente.');
    }

    public function edit(Disponibilidad $disponibilidad)
    {
        if ($disponibilidad->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        return view('disponibilidades.edit', compact('disponibilidad'));
    }

    public function update(Request $request, Disponibilidad $disponibilidad)
    {
        if ($disponibilidad->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $data = $request->validate([
            'especialidad' => 'required|string|max:50',
            'dia_semana' => 'required|string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'precio_consulta' => 'required|numeric|min:0',
            'activo' => 'required|boolean',
        ]);

        $disponibilidad->update($data);

        return redirect()->route('disponibilidades.index')->with('success', 'Disponibilidad actualizada correctamente.');
    }

    public function destroy(Disponibilidad $disponibilidad)
    {
        if ($disponibilidad->user_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $disponibilidad->delete();

        return redirect()->route('disponibilidades.index')->with('success', 'Disponibilidad eliminada correctamente.');
    }

    // Para que los productores vean doctores disponibles
    public function buscarProfesionales(Request $request)
    {
        $especialidad = $request->get('especialidad');
        $dia_semana = $request->get('dia_semana');

        $query = Disponibilidad::where('activo', true);

        if ($especialidad) {
            $query->where('especialidad', $especialidad);
        }

        if ($dia_semana) {
            $query->where('dia_semana', $dia_semana);
        }

        $disponibilidades = $query->with('user')->get();

        return view('disponibilidades.buscar', compact('disponibilidades', 'especialidad', 'dia_semana'));
    }
}