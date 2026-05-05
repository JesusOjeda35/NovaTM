<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receta extends Model
{
    protected $table = 'recetas';
    protected $primaryKey = 'id_receta';
    public $timestamps = false;

    protected $fillable = [
        'usuarios_id',
        'animales_id_animal',
        'fecha',
        'medicamento',
        'dosis',
        'duracion',
        'indicaciones',
        'notas',
        'archivos_adjuntos',
        'firma_digital',
        'sincronizado',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animales_id_animal', 'id_animal');
    }
}