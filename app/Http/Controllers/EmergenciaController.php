<?php

namespace App\Http\Controllers;

use App\Models\Emergencias;
use App\Models\User;
use App\Models\Animal;
use Illuminate\Http\Request;

class EmergenciaController extends Controller
{
    public function index()
    {
        $emergencias = Emergencias::with('UserReporta', 'UserAtiende', 'animal')->latest('id_emergencia')->paginate(10);
        return view('emergencias.index', compact('emergencias'));
    }

    public function create()
    {
        $animales = Animal::orderBy('nombre')->get();
        return view('emergencias.create', compact('animales'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'animales_id_animal' => 'required|exists:animales,id_animal',
            'sintomas_graves' => 'required|string|max:300',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'direccion_texto' => 'nullable|string|max:200',
        ]);

        $data['Users_id'] = $User->id;
        $data['estado'] = 'pendiente';
        $data['fecha_reporte'] = now();
        $data['sincronizado'] = 'N';

        Emergencias::create($data);

        return redirect()->route('emergencias.index')->with('success', 'Emergencia reportada correctamente.');
    }

    public function show(Emergencias $emergencia)
    {
        $emergencia->load('UserReporta', 'UserAtiende', 'animal');
        return view('emergencias.show', compact('emergencia'));
    }

    public function edit(Emergencias $emergencia)
    {
        return view('emergencias.edit', compact('emergencia'));
    }

    public function update(Request $request, Emergencias $emergencia)
    {
        $data = $request->validate([
            'triage_resultado' => 'nullable|string|max:30',
            'estado' => 'required|string|max:20',
        ]);

        if ($emergencia->estado === 'pendiente' && $data['estado'] === 'atendida') {
            $data['Users_id2'] = auth()->user()->id;
        }

        $emergencia->update($data);

        return redirect()->route('emergencias.index')->with('success', 'Emergencia actualizada correctamente.');
    }

    public function destroy(Emergencias $emergencia)
    {
        $emergencia->delete();

        return redirect()->route('emergencias.index')->with('success', 'Emergencia eliminada correctamente.');
    }

    // ========== NUEVOS MÉTODOS PARA EMERGENCIA PÚBLICA ==========

    public function showPublica()
    {
        $profesionales = User::where('rol', 'veterinario')
                             ->orWhere('rol', 'especialista')
                             ->where('estado', 'A')
                             ->orderBy('nombre_completo')
                             ->get();
        
        return view('emergencias.publica', compact('profesionales'));
    }

    public function storePublica(Request $request)
    {
        $data = $request->validate([
            'nombre_animal' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'sintomas_graves' => 'required|string|max:500',
            'telefono_contacto' => 'required|string|max:20',
            'email_contacto' => 'required|email|max:100',
            'direccion_texto' => 'nullable|string|max:300',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);

        // Crear emergencia sin usuario autenticado
        $data['Users_id'] = null;  // Sin usuario (público)
        $data['estado'] = 'pendiente';
        $data['fecha_reporte'] = now();
        $data['sincronizado'] = 'N';
        $data['animales_id_animal'] = null;  // No hay animal registrado

        Emergencias::create($data);

        return redirect()->route('emergencia.publica')
                       ->with('success', '✅ Emergencia reportada correctamente. Un profesional se contactará pronto.');
    }
}