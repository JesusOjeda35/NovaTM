<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidades';

    protected $fillable = [
        'user_id',
        'especialidad',
        'dia_semana',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'precio_consulta',
        'activo',
    ];

    protected $casts = [
        'fecha' => 'date',
        'activo' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'disponibilidad_id', 'id');
    }
}