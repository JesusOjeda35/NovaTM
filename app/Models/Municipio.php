<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Municipio extends Model
{
    protected $table = 'municipios';
    public $timestamps = true;

    protected $fillable = [
        'departamento_id',
        'nombre',
    ];

    // ==================== RELACIONES ====================

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function Users(): HasMany
    {
        return $this->hasMany(User::class, 'municipio_id', 'id');
    }
}