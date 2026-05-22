<?php

namespace App\Http\Controllers;

use App\Models\Mensajes;
use App\Models\User;
use App\Models\Consulta;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    public function index()
    {
        $User = auth()->user();

        if ($User->rol === 'productor') {
            // Mostrar solo mensajes del productor
            $mensajes = Mensajes::where('Users_id', $User->id)
                ->orWhere('Users_id2', $User->id)
                ->with('emisor', 'receptor', 'consulta')
                ->latest('id_mensaje')
                ->paginate(10);
        } else {
            // Mostrar todos los mensajes para veterinario/especialista
            $mensajes = Mensajes::with('emisor', 'receptor', 'consulta')
                ->latest('id_mensaje')
                ->paginate(10);
        }

        return view('mensajes.index', compact('mensajes'));
    }

    public function create()
    {
        $consultas = Consulta::orderBy('id_consulta')->get();
        return view('mensajes.create', compact('consultas'));
    }

    public function store(Request $request)
    {
        $User = auth()->user();

        $data = $request->validate([
            'consultas_id_consulta' => 'required|exists:consultas,id_consulta',
            'Users_id2' => 'required|exists:Users,id',
            'contenido' => 'required|string|max:2000',
            'tipo_contenido' => 'nullable|string|max:20',
            'url_adjunto' => 'nullable|string|max:200',
        ]);

        $data['Users_id'] = $User->id;
        $data['fecha_envio'] = now();
        $data['leido'] = 'N';
        $data['sincronizado'] = 'N';

        Mensajes::create($data);

        return redirect()->route('productor.mensajes')->with('success', 'Mensaje enviado correctamente.');
    }

    public function show(Mensajes $mensaje)
    {
        $mensaje->load('emisor', 'receptor', 'consulta');
        
        // Marcar como leído
        if ($mensaje->Users_id2 === auth()->user()->id && $mensaje->leido === 'N') {
            $mensaje->update(['leido' => 'S']);
        }

        return view('mensajes.show', compact('mensaje'));
    }

    public function edit(Mensajes $mensaje)
    {
        // Solo el emisor puede editar
        if ($mensaje->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        return view('mensajes.edit', compact('mensaje'));
    }

    public function update(Request $request, Mensajes $mensaje)
    {
        // Solo el emisor puede actualizar
        if ($mensaje->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $data = $request->validate([
            'contenido' => 'required|string|max:2000',
            'tipo_contenido' => 'nullable|string|max:20',
            'url_adjunto' => 'nullable|string|max:200',
        ]);

        $mensaje->update($data);

        return redirect()->route('productor.mensajes')->with('success', 'Mensaje actualizado correctamente.');
    }

    public function destroy(Mensajes $mensaje)
    {
        // Solo el emisor puede eliminar
        if ($mensaje->Users_id !== auth()->user()->id) {
            abort(403, 'No autorizado.');
        }

        $mensaje->delete();

        return redirect()->route('productor.mensajes')->with('success', 'Mensaje eliminado correctamente.');
    }
}