<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function show()
    {
        $paises = Pais::all();
        return view('auth.register', compact('paises'));
    }

    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:100',
            'email' => 'required|string|email|max:80|unique:users',
            'documento' => 'nullable|string|max:20|unique:users',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:150',
            'pais_id' => 'nullable|exists:paises,id',
            'departamento_id' => 'nullable|exists:departamentos,id',
            'municipio_id' => 'nullable|exists:municipios,id',
            'rol' => 'required|string|in:productor,veterinario,especialista',
            'especialidad' => 'nullable|string|max:50',
            'tarjeta_profesional' => 'nullable|string|max:30',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Crear usuario
            $user = User::create([
                'nombre_completo' => $request->nombre_completo,
                'email' => $request->email,
                'documento' => $request->documento,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion,
                'pais_id' => $request->pais_id,
                'departamento_id' => $request->departamento_id,
                'municipio_id' => $request->municipio_id,
                'rol' => $request->rol,
                'especialidad' => $request->especialidad,
                'tarjeta_profesional' => $request->tarjeta_profesional,
                'password_hash' => Hash::make($request->password),
                'estado' => 'A',
            ]);

            return redirect()->route('login')
                ->with('status', 'Cuenta creada exitosamente. Por favor inicia sesión.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear la cuenta: ' . $e->getMessage()])
                ->withInput();
        }
    }
}