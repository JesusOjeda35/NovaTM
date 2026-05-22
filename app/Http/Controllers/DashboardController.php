<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class DashboardController extends Controller
{
    /**
     * Redirigir al dashboard según el rol
     */
    public function index()
    {
        $User = auth()->user();
        $rol = $User->rol;

        if ($rol === 'productor') {
            return redirect()->route('productor.animales');
        } elseif ($rol === 'veterinario' || $rol === 'especialista') {
            return redirect()->route('profesional.pacientes');
        }

        return redirect()->route('login');
    }

    /**
     * Ver los pacientes (animales) del profesional
     */
    public function misPacientes()
    {
        $User = auth()->user();
        
        // Solo profesionales ven pacientes
        if (!$User->isProfesional()) {
            abort(403, 'No autorizado.');
        }

        // Obtener todos los animales (pacientes del profesional)
        $animales = Animal::with('User', 'consultas')
            ->latest('id_animal')
            ->paginate(10);

        return view('profesional.pacientes', compact('animales'));
    }
}