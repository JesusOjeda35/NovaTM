<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuracion extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id_config';
    public $timestamps = false;

    protected $fillable = [
        'usuarios_id',
        'clave',
        'valor',
        'actualizado',
    ];

    protected $casts = [
        'actualizado' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'usuarios_id', 'id');
    }
}