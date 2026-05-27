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
        'eliminado_por_emisor',
        'eliminado_por_receptor',
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

    public function getHoraFormato()
    {
        return $this->fecha_envio->format('H:i');
    }

    public function getFechaFormato()
    {
        $hoy = now()->toDateString();
        $fecha = $this->fecha_envio->toDateString();

        if ($fecha === $hoy) {
            return $this->getHoraFormato();
        }

        if ($fecha === now()->subDay()->toDateString()) {
            return 'Ayer';
        }

        return $this->fecha_envio->format('d/m/Y');
    }
}