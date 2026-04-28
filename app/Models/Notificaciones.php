<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'usuarios_id',
        'tipo',
        'contenido',
        'leido',
        'fecha_creacion',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }
}