<?php

namespace App\Http\Controllers;

use App\Models\Mensajes;
use App\Models\User;
use App\Models\Consulta;
use Illuminate\Http\Request;

class MensajeController extends Controller
{
    /**
     * Mostrar lista de conversaciones (agrupadas por usuario)
     */
    public function index()
    {
        $usuarioActual = auth()->user();
        
        // Obtener todos los usuarios con los que tiene conversaciones
        $conversaciones = Mensajes::where(function ($query) use ($usuarioActual) {
            $query->where('Users_id', $usuarioActual->id)
                  ->orWhere('Users_id2', $usuarioActual->id);
        })
        ->with('emisor', 'receptor')
        ->latest('fecha_envio')
        ->get()
        ->groupBy(function ($mensaje) use ($usuarioActual) {
            // Agrupar por el otro usuario (no el actual)
            return $mensaje->Users_id === $usuarioActual->id ? $mensaje->Users_id2 : $mensaje->Users_id;
        })
        ->map(function ($mensajes) {
            return [
                'usuario_id' => $mensajes->first()->Users_id === auth()->id() ? $mensajes->first()->Users_id2 : $mensajes->first()->Users_id,
                'usuario' => $mensajes->first()->Users_id === auth()->id() ? $mensajes->first()->receptor : $mensajes->first()->emisor,
                'ultimo_mensaje' => $mensajes->first(),
                'no_leidos' => $mensajes->where('Users_id2', auth()->id())->where('leido', 'N')->count(),
            ];
        })
        ->values();

        return view('mensajes.index', compact('conversaciones'));
    }

    /**
     * Mostrar conversación con un usuario específico
     */
    public function show($usuarioId)
    {
        $usuarioActual = auth()->user();
        $usuarioChat = User::findOrFail($usuarioId);

        // Obtener todos los mensajes de la conversación
        $mensajes = Mensajes::where(function ($query) use ($usuarioActual, $usuarioId) {
            $query->where('Users_id', $usuarioActual->id)->where('Users_id2', $usuarioId)
                  ->orWhere('Users_id', $usuarioId)->where('Users_id2', $usuarioActual->id);
        })
        ->with('emisor', 'receptor', 'consulta')
        ->orderBy('fecha_envio', 'asc')
        ->get();

        // Marcar como leídos todos los mensajes recibidos
        Mensajes::where('Users_id', $usuarioId)
            ->where('Users_id2', $usuarioActual->id)
            ->where('leido', 'N')
            ->update(['leido' => 'S']);

        return view('mensajes.show', compact('usuarioChat', 'mensajes', 'usuarioActual'));
    }

    /**
     * Crear nuevo mensaje
     */
    public function create()
    {
        $usuarioActual = auth()->user();
        
        // Obtener profesionales disponibles
        $profesionales = User::where('estado', 'A')
            ->where(function ($query) {
                $query->where('rol', 'veterinario')
                      ->orWhere('rol', 'especialista');
            })
            ->orderBy('nombre_completo')
            ->get();

        return view('mensajes.create', compact('profesionales'));
    }

    /**
     * Guardar nuevo mensaje
     */
    public function store(Request $request)
    {
        $usuarioActual = auth()->user();

        $data = $request->validate([
            'Users_id2' => 'required|exists:Users,id',
            'contenido' => 'required|string|max:2000',
            'archivo' => 'nullable|file|max:5120', // 5MB máximo
        ]);

        // Procesar archivo si existe
        $urlAdjunto = null;
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $archivo->storeAs('mensajes', $nombreArchivo, 'public');
            $urlAdjunto = 'storage/mensajes/' . $nombreArchivo;
        }

        $data['Users_id'] = $usuarioActual->id;
        $data['fecha_envio'] = now();
        $data['leido'] = 'N';
        $data['sincronizado'] = 'N';
        $data['url_adjunto'] = $urlAdjunto;
        $data['tipo_contenido'] = $request->hasFile('archivo') ? 'archivo' : 'texto';
        unset($data['archivo']);

        Mensajes::create($data);

        return redirect()->route('mensaje.show', $data['Users_id2'])
                       ->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Eliminar mensaje (soft delete)
     */
    public function destroy($mensajeId)
    {
        $mensaje = Mensajes::findOrFail($mensajeId);
        $usuarioActual = auth()->user();

        // Solo puede eliminar quien envió o recibió
        if ($mensaje->Users_id !== $usuarioActual->id && $mensaje->Users_id2 !== $usuarioActual->id) {
            abort(403, 'No autorizado.');
        }

        // Marcar como eliminado para este usuario
        if ($mensaje->Users_id === $usuarioActual->id) {
            $mensaje->update(['eliminado_por_emisor' => true]);
        } else {
            $mensaje->update(['eliminado_por_receptor' => true]);
        }

        return back()->with('success', 'Mensaje eliminado.');
    }
}