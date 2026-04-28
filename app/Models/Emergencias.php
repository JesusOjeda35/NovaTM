<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emergencia extends Model
{
    protected $table = 'emergencias';
    protected $primaryKey = 'id_emergencia';
    public $timestamps = false;

    protected $fillable = [
        'usuarios_id',
        'usuarios_id2',
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
        'latitud' => 'decimal:8',
        'longitud' => 'decimal:8',
    ];

    public function usuarioReporta(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }

    public function usuarioAtiende(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id2', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
    }
}