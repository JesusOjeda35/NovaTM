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

    protected $fillable = [
        'usuarios_id',
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

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
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
        return $this->hasMany(Emergencia::class, 'animales_id_animal', 'id_animal');
    }
}