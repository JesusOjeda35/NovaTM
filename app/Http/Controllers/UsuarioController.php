<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::latest('id')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'documento' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|max:80|unique:usuarios,email',
            'direccion' => 'nullable|string|max:150',
            'rol' => 'required|string|max:20',
            'especialidad' => 'nullable|string|max:50',
            'tarjeta_profesional' => 'nullable|string|max:30',
            'estado' => 'required|string|size:1',
            'registrado_por' => 'nullable|string|max:20',
            'password_hash' => 'required|string|max:200',
        ]);

        $data['timestamp_registro'] = now();

        Usuario::create($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'documento' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|max:80|unique:usuarios,email,' . $usuario->id,
            'direccion' => 'nullable|string|max:150',
            'rol' => 'required|string|max:20',
            'especialidad' => 'nullable|string|max:50',
            'tarjeta_profesional' => 'nullable|string|max:30',
            'estado' => 'required|string|size:1',
            'registrado_por' => 'nullable|string|max:20',
            'password_hash' => 'required|string|max:200',
        ]);

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}