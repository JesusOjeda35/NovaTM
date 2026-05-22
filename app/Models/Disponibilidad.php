<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidades';

    protected $fillable = [
        'user_id',
        'especialidad',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'precio_consulta',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}