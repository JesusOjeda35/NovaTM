<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    protected $table = 'departamentos';
    public $timestamps = true;

    protected $fillable = [
        'pais_id',
        'nombre',
    ];

    // ==================== RELACIONES ====================

    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'departamento_id', 'id');
    }

    public function Users(): HasMany
    {
        return $this->hasMany(User::class, 'departamento_id', 'id');
    }
}