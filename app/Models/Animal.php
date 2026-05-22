<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Animal extends Model
{
    protected $table = 'animales';
    protected $primaryKey = 'id_animal';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'nombre',
        'identificacion_propia',
        'especie',
        'raza',
        'edad',
        'peso',
        'estado_salud',
        'foto_url',
        'fecha_registro',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_registro' => 'date',
    ];

    // ==================== RELACIONES ====================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'animales_id_animal', 'id_animal');
    }

    public function historialesClinicos(): HasMany
    {
        return $this->hasMany(HistorialClinico::class, 'animales_id_animal', 'id_animal');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'animales_id_animal', 'id_animal');
    }

    public function emergencias(): HasMany
    {
        return $this->hasMany(Emergencias::class, 'animales_id_animal', 'id_animal');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isSincronizado(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function getEstadoAttribute()
    {
        return $this->estado_salud ?? 'Sin especificar';
    }
}