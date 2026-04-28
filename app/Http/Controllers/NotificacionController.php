<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::with('usuario')->latest('id_notificacion')->paginate(10);
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        return view('notificaciones.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'tipo' => 'required|string|max:30',
            'contenido' => 'required|string|max:300',
            'leido' => 'nullable|string|size:1',
            'fecha_creacion' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Notificacion::create($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada correctamente.');
    }

    public function show(Notificacion $notificacione)
    {
        $notificacione->load('usuario');
        return view('notificaciones.show', compact('notificacione'));
    }

    public function edit(Notificacion $notificacione)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        return view('notificaciones.edit', compact('notificacione', 'usuarios'));
    }

    public function update(Request $request, Notificacion $notificacione)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'tipo' => 'required|string|max:30',
            'contenido' => 'required|string|max:300',
            'leido' => 'nullable|string|size:1',
            'fecha_creacion' => 'nullable|date',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $notificacione->update($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada correctamente.');
    }

    public function destroy(Notificacion $notificacione)
    {
        $notificacione->delete();

        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada correctamente.');
    }
}