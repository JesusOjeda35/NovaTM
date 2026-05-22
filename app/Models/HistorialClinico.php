<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialClinico extends Model
{
    protected $table = 'historiales_clinicos';
    protected $primaryKey = 'id_historial';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'animales_id_animal',
        'fecha',
        'tipo_evento',
        'descripcion',
        'diagnostico',
        'tratamiento',
        'archivos_adjuntos',
        'firma_digital',
        'sincronizado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
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
}