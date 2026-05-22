<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emergencias extends Model
{
    protected $table = 'emergencias';
    protected $primaryKey = 'id_emergencia';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'Users_id2',
        'animales_id_animal',
        'fecha_reporte',
        'sintomas_graves',
        'latitud',
        'longitud',
        'direccion_texto',
        'triage_resultado',
        'estado',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_reporte' => 'datetime',
        'latitud' => 'float',
        'longitud' => 'float',
    ];

    // ==================== RELACIONES ====================

    public function UserReporta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id', 'id');
    }

    public function UserAtiende(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id2', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
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

    public function isSincronizada(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function tieneUbicacion(): bool
    {
        return $this->latitud !== null && $this->longitud !== null;
    }
}