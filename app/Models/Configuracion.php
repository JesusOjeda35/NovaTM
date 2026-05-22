<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Configuracion extends Model
{
    protected $table = 'configuracion';
    protected $primaryKey = 'id_config';
    public $timestamps = false;
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'Users_id',
        'clave',
        'valor',
        'actualizado',
    ];

    protected $casts = [
        'actualizado' => 'datetime',
    ];

    // ==================== RELACIONES ====================

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'Users_id', 'id');
    }

    // ==================== MÉTODOS HELPER ====================

    public static function obtener(int $UserId, string $clave, $default = null)
    {
        $config = self::where('Users_id', $UserId)
            ->where('clave', $clave)
            ->first();

        return $config ? $config->valor : $default;
    }

    public static function guardar(int $UserId, string $clave, $valor): self
    {
        return self::updateOrCreate(
            ['Users_id' => $UserId, 'clave' => $clave],
            ['valor' => $valor, 'actualizado' => now()]
        );
    }
}