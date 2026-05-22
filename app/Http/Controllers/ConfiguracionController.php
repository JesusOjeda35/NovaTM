<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use App\Models\User;
use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::with('User')->latest('id_config')->paginate(10);
        return view('configuracion.index', compact('configuraciones'));
    }

    public function create()
    {
        $Users = User::orderBy('nombre_completo')->get();
        return view('configuracion.create', compact('Users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Users_id' => 'required|exists:Users,id',
            'clave' => 'required|string|max:50',
            'valor' => 'nullable|string|max:200',
            'actualizado' => 'nullable|date',
        ]);

        Configuracion::create($data);

        return redirect()->route('configuracion.index')->with('success', 'Configuración creada correctamente.');
    }

    public function show(Configuracion $configuracion)
    {
        $configuracion->load('User');
        return view('configuracion.show', compact('configuracion'));
    }

    public function edit(Configuracion $configuracion)
    {
        $Users = User::orderBy('nombre_completo')->get();
        return view('configuracion.edit', compact('configuracion', 'Users'));
    }

    public function update(Request $request, Configuracion $configuracion)
    {
        $data = $request->validate([
            'Users_id' => 'required|exists:Users,id',
            'clave' => 'required|string|max:50',
            'valor' => 'nullable|string|max:200',
            'actualizado' => 'nullable|date',
        ]);

        $configuracion->update($data);

        return redirect()->route('configuracion.index')->with('success', 'Configuración actualizada correctamente.');
    }

    public function destroy(Configuracion $configuracion)
    {
        $configuracion->delete();

        return redirect()->route('configuracion.index')->with('success', 'Configuración eliminada correctamente.');
    }
}