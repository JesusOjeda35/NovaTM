<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PasswordResetController extends Controller
{
    /**
     * Mostrar formulario para solicitar reset
     */
    public function showEmailForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Enviar enlace de reset
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:Users,email']);

        $User = User::where('email', $request->email)->first();
        
        if (!$User) {
            return back()->withErrors(['email' => 'No encontramos una cuenta con ese email']);
        }

        // Generar token temporal (válido por 1 hora)
        $token = Str::random(60);
        Cache::put('password_reset_' . $token, $User->id, now()->addHour());

        // Generar el enlace de recuperación
        $resetLink = route('password.reset', ['token' => $token, 'email' => $User->email]);

        return back()->with('status', $resetLink);
    }

    /**
     * Mostrar formulario de reset con token
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Verificar que el token sea válido
        $UserId = Cache::get('password_reset_' . $token);

        if (!$UserId) {
            return redirect('/password/reset')->withErrors(['token' => 'El enlace ha expirado. Por favor solicita uno nuevo.']);
        }

        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->query('email') ?? ''
        ]);
    }

    /**
     * Procesar reset de contraseña
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:Users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Verificar que el token sea válido
        $UserId = Cache::get('password_reset_' . $request->token);

        if (!$UserId) {
            return back()->withErrors(['token' => 'El enlace de recuperación es inválido o ha expirado']);
        }

        $User = User::find($UserId);

        if ($User->email !== $request->email) {
            return back()->withErrors(['email' => 'El email no coincide']);
        }

        // Actualizar contraseña
        $User->update([
            'password_hash' => Hash::make($request->password)
        ]);

        // Eliminar el token usado
        Cache::forget('password_reset_' . $request->token);

        return redirect('/login')->with('status', 'Contraseña restablecida exitosamente. Por favor inicia sesión.');
    }
}