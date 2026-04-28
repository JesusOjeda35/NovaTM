<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Usuario;
use App\Models\Consulta;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public function index()
    {
        $mensajes = Mensaje::with('emisor', 'receptor', 'consulta')->latest('id_mensaje')->paginate(10);
        return view('mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $consultas = Consulta::orderBy('id_consulta')->get();

        return view('mensajes.create', compact('usuarios', 'consultas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'usuarios_id2' => 'required|exists:usuarios,id',
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'contenido' => 'required|string|max:2000',
            'tipo_contenido' => 'nullable|string|max:20',
            'url_adjunto' => 'nullable|string|max:200',
            'fecha_envio' => 'nullable|date',
            'leido' => 'nullable|string|size:1',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        Mensaje::create($data);

        return redirect()->route('mensajes.index')->with('success', 'Mensaje creado correctamente.');
    }

    public function show(Mensaje $mensaje)
    {
        $mensaje->load('emisor', 'receptor', 'consulta');
        return view('mensajes.show', compact('mensaje'));
    }

    public function edit(Mensaje $mensaje)
    {
        $usuarios = Usuario::orderBy('nombre_completo')->get();
        $consultas = Consulta::orderBy('id_consulta')->get();

        return view('mensajes.edit', compact('mensaje', 'usuarios', 'consultas'));
    }

    public function update(Request $request, Mensaje $mensaje)
    {
        $data = $request->validate([
            'usuarios_id' => 'required|exists:usuarios,id',
            'usuarios_id2' => 'required|exists:usuarios,id',
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'contenido' => 'required|string|max:2000',
            'tipo_contenido' => 'nullable|string|max:20',
            'url_adjunto' => 'nullable|string|max:200',
            'fecha_envio' => 'nullable|date',
            'leido' => 'nullable|string|size:1',
            'sincronizado' => 'nullable|string|size:1',
        ]);

        $mensaje->update($data);

        return redirect()->route('mensajes.index')->with('success', 'Mensaje actualizado correctamente.');
    }

    public function destroy(Mensaje $mensaje)
    {
        $mensaje->delete();

        return redirect()->route('mensajes.index')->with('success', 'Mensaje eliminado correctamente.');
    }
}