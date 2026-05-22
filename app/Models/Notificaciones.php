<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificaciones extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'tipo',
        'contenido',
        'leido',
        'fecha_creacion',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
    ];

    // ==================== RELACIONES ====================

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id', 'id');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isLeida(): bool
    {
        return $this->leido === 'S';
    }

    public function isSincronizada(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function marcarComoLeida(): void
    {
        $this->update(['leido' => 'S']);
    }
}