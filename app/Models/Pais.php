<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pais extends Model
{
    protected $table = 'paises';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'codigo',
    ];

    // ==================== RELACIONES ====================

    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class, 'pais_id', 'id');
    }

    public function Users(): HasMany
    {
        return $this->hasMany(User::class, 'pais_id', 'id');
    }
}