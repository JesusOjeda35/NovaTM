<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        $rol = $usuario->rol;

        if ($rol === 'productor') {
            return redirect()->route('productor.animales');
        } elseif ($rol === 'veterinario' || $rol === 'especialista') {
            return redirect()->route('profesional.pacientes');
        }

        return redirect()->route('login');
    }

    // PRODUCTOR - Ver sus animales
    public function misAnimales()
    {
        $animales = Animal::where('usuarios_id', auth()->id())->get();
        return view('productor.animales', compact('animales'));
    }

    // PROFESIONAL - Ver sus pacientes
    public function misPacientes()
    {
        return view('profesional.pacientes');
    }
}