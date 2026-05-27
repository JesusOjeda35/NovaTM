<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HistorialClinico extends Model
{
    protected $table = 'historiales_clinicos';
    protected $primaryKey = 'id_historial';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'animales_id_animal',
        'consulta_id',
        'fecha',
        'tipo_evento',
        'descripcion',
        'diagnostico',
        'tratamiento',
        'archivos_adjuntos',
        'firma_digital',
        'sincronizado',
        // ANAMNESIS
        'alimentacion_dieta',
        'enfermedades_previas',
        'cirugias_previas',
        'numero_partos',
        'esquema_vacunal',
        'ultima_desparasitacion',
        'tratamientos_recientes',
        'convive_otros_animales',
        'cuales_animales',
        // EXAMEN FÍSICO
        'temperatura',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'otros_hallazgos_fisicos',
        // OBSERVACIONES
        'observaciones',
        'recomendaciones_finales',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'convive_otros_animales' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'consulta_id', 'id_consulta');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'historial_id', 'id_historial');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isSincronizado(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function tieneAdjuntos(): bool
    {
        return !empty($this->archivos_adjuntos);
    }

    public function tieneSignatura(): bool
    {
        return !empty($this->firma_digital);
    }

    public function esProfesional($userId): bool
    {
        return $this->user_id === $userId;
    }
}