<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Receta extends Model
{
    protected $table = 'recetas';
    protected $primaryKey = 'id_receta';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'animales_id_animal',
        'consultas_id_consulta',
        'fecha_emision',
        'fecha_vencimiento',
        'diagnostico',
        'indicaciones_generales',
        'notas_adicionales',
        'firma_electronica',
        'estado',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
        'fecha_vencimiento' => 'date',
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
        return $this->belongsTo(Consulta::class, 'consultas_id_consulta', 'id_consulta');
    }

    public function medicamentos(): HasMany
    {
        return $this->hasMany(RecetaMedicamentos::class, 'recetas_id', 'id_receta');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isActiva(): bool
    {
        return $this->estado === 'activa';
    }

    public function isVencida(): bool
    {
        return $this->fecha_vencimiento && $this->fecha_vencimiento->isPast();
    }

    public function isSincronizada(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function tieneSignatura(): bool
    {
        return !empty($this->firma_electronica);
    }
}