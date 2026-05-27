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
        // Si es profesional, mostrar sus citas apartadas
        if (auth()->user()->isProfesional()) {
            // Obtener IDs de disponibilidades del profesional
            $disponibilidadesIds = Disponibilidad::where('user_id', auth()->user()->id)
                ->pluck('id');

            // Obtener consultas que usan esas disponibilidades
            $consultas = Consulta::with('animal', 'User', 'disponibilidad')
                ->whereIn('disponibilidad_id', $disponibilidadesIds)
                ->latest('id_consulta')
                ->paginate(10);
            
            $disponibilidades = Disponibilidad::where('user_id', auth()->user()->id)
                ->orderBy('fecha')
                ->orderBy('dia_semana')
                ->orderBy('hora_inicio')
                ->get();
            
            return view('consultas.index-profesional', compact('consultas', 'disponibilidades'));
        }

        // Si es productor, mostrar consultas
        $consultas = Consulta::with('User', 'animal')->latest('id_consulta')->paginate(10);
        return view('consultas.index', compact('consultas'));
    }

    public function misConsultas()
    {
        $User = auth()->user();
        $consultas = Consulta::where('user_id', $User->id)
            ->with('animal', 'mensajes', 'disponibilidad')
            ->latest('id_consulta')
            ->paginate(10);
        return view('consultas.mis-consultas', compact('consultas'));
    }

    public function buscarProfesionales()
    {
        // Solo mostrar disponibilidades que no tienen consulta agendada
        $disponibilidades = Disponibilidad::where('activo', true)
            ->whereDoesntHave('consultas')
            ->with('user')
            ->orderBy('user_id')
            ->orderBy('fecha')
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();
        
        return view('disponibilidades.buscar-profesionales', compact('disponibilidades'));
    }

    public function create(Request $request)
    {
        $animales = Animal::where('user_id', auth()->id())
            ->orderBy('nombre')
            ->get();
        
        $tiposConsulta = ['General', 'Vacunación', 'Cirugía', 'Dental', 'Emergencia'];
        $nivelesUrgencia = ['Bajo', 'Medio', 'Alto', 'Crítico'];
        $disponibilidad_id = $request->query('disponibilidad_id');
        
        return view('consultas.create', compact('animales', 'tiposConsulta', 'nivelesUrgencia', 'disponibilidad_id'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'disponibilidad_id' => 'nullable|exists:disponibilidades,id',
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'tipo_consulta' => 'required|string|max:20',
            'motivo' => 'nullable|string|max:300',
            'urgencia' => 'nullable|string|max:15',
        ]);

        $data['user_id'] = $User->id;
        $data['estado'] = 'agendada';
        $data['fecha_solicitud'] = now();
        $data['sincronizado'] = 'N';

        Consulta::create($data);

        return redirect()->route('productor.consultas')->with('success', 'Consulta agendada correctamente.');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load('User', 'animal', 'mensajes', 'recetas', 'disponibilidad');
        return view('consultas.show', compact('consulta'));
    }

    /**
     * Atender cita - Redirige al formulario de historial clínico
     * NO cambia el estado de la consulta
     */
    public function attend(Consulta $consulta)
    {
        // Solo profesionales pueden atender citas
        if (!auth()->user()->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        // Redirigir al formulario de crear historial clínico con la consulta_id
        // NO cambiar el estado aquí - se mantiene como "agendada"
        return redirect()->route('historial.create', ['consulta_id' => $consulta->id_consulta])
            ->with('info', 'Ahora completa el historial clínico del paciente.');
    }

    public function edit(Consulta $consulta)
    {
        // Solo profesionales pueden editar
        if (!auth()->user()->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        $consulta->load('animal', 'User');

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