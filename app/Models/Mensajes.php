<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mensaje extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'id_mensaje';
    public $timestamps = false;

    protected $fillable = [
        'usuarios_id',
        'usuarios_id2',
        'consultas_id_consulta',
        'contenido',
        'tipo_contenido',
        'url_adjunto',
        'fecha_envio',
        'leido',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    public function emisor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }

    public function receptor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id2', 'id');
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'consultas_id_consulta', 'id_consulta');
    }
}