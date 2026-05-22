<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use App\Models\User;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificaciones::with('User')->latest('id_notificacion')->paginate(10);
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $Users = User::orderBy('nombre_completo')->get();
        return view('notificaciones.create', compact('Users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Users_id' => 'required|exists:Users,id',
            'tipo' => 'required|string|max:30',
            'contenido' => 'required|string|max:300',
            'leido' => 'nullable|string|size:1',
            'fecha_creacion' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Notificaciones::create($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    public function show(Notificaciones $notificacione)
    {
        $notificacione->load('User');
        return view('notificaciones.show', compact('notificacione'));
    }

    public function edit(Notificaciones $notificacione)
    {
        $Users = User::orderBy('nombre_completo')->get();
        return view('notificaciones.edit', compact('notificacione', 'Users'));
    }

    public function update(Request $request, Notificaciones $notificacione)
    {
        $data = $request->validate([
            'Users_id' => 'required|exists:Users,id',
            'tipo' => 'required|string|max:30',
            'contenido' => 'required|string|max:300',
            'leido' => 'nullable|string|size:1',
            'fecha_creacion' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $notificacione->update($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy(Notificaciones $notificacione)
    {
        $notificacione->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
}