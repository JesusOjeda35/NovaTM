<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicamento extends Model
{
    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';
    public $timestamps = true;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'categoria',
        'descripcion',
        'dosis_recomendada',
        'via_administracion',
    ];

    // ==================== RELACIONES ====================

    public function recetaMedicamentos(): HasMany
    {
        return $this->hasMany(RecetaMedicamentos::class, 'medicamentos_id_medicamento', 'id_medicamento');
    }
}