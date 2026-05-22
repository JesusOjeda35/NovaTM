<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consulta extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'animales_id_animal',
        'tipo_consulta',
        'estado',
        'fecha_solicitud',
        'fecha_atencion',
        'motivo',
        'urgencia',
        'diagnostico_resumido',
        'recomendaciones',
        'requiere_presencial',
        'id_consulta_referencia',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_atencion' => 'datetime',
    ];

    // ==================== RELACIONES ====================

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(Mensajes::class, 'consultas_id_consulta', 'id_consulta');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'consultas_id_consulta', 'id_consulta');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function isAtendida(): bool
    {
        return $this->estado === 'atendida';
    }

    public function isCancelada(): bool
    {
        return $this->estado === 'cancelada';
    }

    public function isUrgente(): bool
    {
        return $this->urgencia === 'alta';
    }

    public function requierePresencial(): bool
    {
        return $this->requiere_presencial === 'S';
    }

    public function isSincronizada(): bool
    {
        return $this->sincronizado === 'S';
    }
}