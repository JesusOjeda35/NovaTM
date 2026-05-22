<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mensajes extends Model
{
    protected $table = 'mensajes';
    protected $primaryKey = 'id_mensaje';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'Users_id2',
        'consultas_id_consulta',
        'contenido',
        'tipo_contenido',
        'url_adjunto',
        'fecha_envio',
        'leido',
        'sincronizado',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
    ];

    // ==================== RELACIONES ====================

    public function emisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id', 'id');
    }

    public function receptor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id2', 'id');
    }

    public function consulta(): BelongsTo
    {
        return $this->belongsTo(Consulta::class, 'consultas_id_consulta', 'id_consulta');
    }

    // ==================== MÉTODOS HELPER ====================

    public function isLeido(): bool
    {
        return $this->leido === 'S';
    }

    public function isSincronizado(): bool
    {
        return $this->sincronizado === 'S';
    }

    public function tieneAdjunto(): bool
    {
        return !empty($this->url_adjunto);
    }

    public function marcarComoLeido(): void
    {
        $this->update(['leido' => 'S']);
    }
}