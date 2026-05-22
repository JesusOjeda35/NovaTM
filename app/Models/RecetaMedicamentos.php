<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecetaMedicamentos extends Model
{
    protected $table = 'receta_medicamentos';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'recetas_id',
        'nombre_medicamento',
        'dosis',
        'via_administracion',
        'duracion',
        'instrucciones',
    ];

    // ==================== RELACIONES ====================

    public function receta(): BelongsTo
    {
        return $this->belongsTo(Receta::class, 'recetas_id', 'id_receta');
    }
}