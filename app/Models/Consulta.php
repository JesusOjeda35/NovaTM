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

    protected $fillable = [
        'usuarios_id',
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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
    }

    public function mensajes(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'consultas_id_consulta', 'id_consulta');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'consultas_id_consulta', 'id_consulta');
    }
}