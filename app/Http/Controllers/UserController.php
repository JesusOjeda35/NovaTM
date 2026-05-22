<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $Users = User::latest('id')->paginate(10);
        return view('Users.index', compact('Users'));
    }

    public function create()
    {
        return view('Users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'documento' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|max:80|unique:Users,email',
            'direccion' => 'nullable|string|max:150',
            'pais_id' => 'nullable|exists:paises,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'municipio_id' => 'nullable|exists:municipios,id',
            'rol' => 'required|string|max:20',
            'especialidad' => 'nullable|string|max:50',
            'tarjeta_profesional' => 'nullable|string|max:30',
            'estado' => 'required|string|size:1',
            'registrado_por' => 'nullable|string|max:20',
            'password_hash' => 'required|string|min:6',
        ]);

        $data['timestamp_registro'] = now();

        User::create($data);

        return redirect()->route('Users.index')->with('success', 'User creado correctamente.');
    }

    public function show(User $user)
    {
        return view('Users.show', ['User' => $user]);
    }

    public function edit(User $user)
    {
        return view('Users.edit', ['User' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nombre_completo' => 'required|string|max:100',
            'documento' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|max:80|unique:Users,email,' . $user->id,
            'direccion' => 'nullable|string|max:150',
            'pais_id' => 'nullable|exists:paises,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'municipio_id' => 'nullable|exists:municipios,id',
            'rol' => 'required|string|max:20',
            'especialidad' => 'nullable|string|max:50',
            'tarjeta_profesional' => 'nullable|string|max:30',
            'estado' => 'required|string|size:1',
            'registrado_por' => 'nullable|string|max:20',
            'password_hash' => 'nullable|string|min:6',
        ]);

        $user->update($data);

        return redirect()->route('Users.index')->with('success', 'User actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('Users.index')->with('success', 'User eliminado correctamente.');
    }
}