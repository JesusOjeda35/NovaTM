<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use App\Models\Pais;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        $usuario = Usuario::where('email', $credentials['email'])->first();

        if ($usuario && Hash::check($credentials['password'], $usuario->password_hash)) {
            Auth::login($usuario);
            $request->session()->regenerate();
            return redirect('/')->with('status', '¡Bienvenido ' . $usuario->nombre_completo . '!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegisterForm()
    {
        $paises = Pais::all();
        return view('auth.register', compact('paises'));
    }

    /**
     * Procesar registro
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'required|string|max:20',
            'documento' => 'required|string|unique:usuarios,documento|max:20',
            'direccion' => 'required|string|max:255',
            'pais_id' => 'required|exists:paises,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'municipio_id' => 'required|exists:municipios,id',
            'rol' => 'required|in:productor,veterinario,especialista',
            'especialidad' => 'nullable|string|max:255',
            'tarjeta_profesional' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'nombre_completo.required' => 'El nombre completo es requerido',
            'email.required' => 'El email es requerido',
            'email.email' => 'El email no es válido',
            'email.unique' => 'Este email ya está registrado',
            'telefono.required' => 'El teléfono es requerido',
            'documento.required' => 'El documento es requerido',
            'documento.unique' => 'Este documento ya está registrado',
            'direccion.required' => 'La dirección es requerida',
            'pais_id.required' => 'El país es requerido',
            'pais_id.exists' => 'El país seleccionado no es válido',
            'departamento_id.required' => 'El departamento es requerido',
            'departamento_id.exists' => 'El departamento seleccionado no es válido',
            'municipio_id.required' => 'El municipio es requerido',
            'municipio_id.exists' => 'El municipio seleccionado no es válido',
            'rol.required' => 'El rol es requerido',
            'rol.in' => 'El rol seleccionado no es válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        try {
            $usuario = Usuario::create([
                'nombre_completo' => $validated['nombre_completo'],
                'email' => $validated['email'],
                'telefono' => $validated['telefono'],
                'documento' => $validated['documento'],
                'direccion' => $validated['direccion'],
                'pais_id' => $validated['pais_id'],
                'departamento_id' => $validated['departamento_id'],
                'municipio_id' => $validated['municipio_id'],
                'rol' => $validated['rol'],
                'especialidad' => $validated['especialidad'] ?? null,
                'tarjeta_profesional' => $validated['tarjeta_profesional'] ?? null,
                'password_hash' => Hash::make($validated['password']),
                'estado' => 'A',
                'timestamp_registro' => now(),
            ]);

            Auth::login($usuario);
            $request->session()->regenerate();
            
            return redirect('/')->with('status', '¡Bienvenido a NovaTM, ' . $usuario->nombre_completo . '!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Ocurrió un error al registrarse. Por favor intenta de nuevo.'])
                ->withInput();
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('status', 'Sesión cerrada correctamente');
    }
}