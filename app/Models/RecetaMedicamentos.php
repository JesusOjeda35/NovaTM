<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecetaMedicamento extends Model
{
    protected $table = 'receta_medicamentos';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'recetas_id',
        'nombre_medicamento',
        'dosis',
        'via_administracion',
        'duracion',
        'instrucciones',
    ];

    public function receta(): BelongsTo
    {
        return $this->belongsTo(Receta::class, 'recetas_id', 'id_receta');
    }
}