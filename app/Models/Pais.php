<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pais extends Model
{
    protected $table = 'paises';
    protected $fillable = ['nombre', 'codigo'];

    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class, 'pais_id');
    }

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'pais_id');
    }
}