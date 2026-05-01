<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre_completo',
        'documento',
        'telefono',
        'email',
        'direccion',
        'pais_id',
        'departamento_id',
        'municipio_id',
        'rol',
        'especialidad',
        'tarjeta_profesional',
        'estado',
        'registrado_por',
        'timestamp_registro',
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'timestamp_registro' => 'datetime',
    ];

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    // Relaciones de localidad
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    // Relaciones existentes
    public function animales(): HasMany
    {
        return $this->hasMany(Animal::class, 'usuarios_id', 'id');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'usuarios_id', 'id');
    }

    public function historialesClinicos(): HasMany
    {
        return $this->hasMany(HistorialClinico::class, 'usuarios_id', 'id');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'usuarios_id', 'id');
    }

    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'usuarios_id', 'id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Mensaje::class, 'usuarios_id2', 'id');
    }

    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'usuarios_id', 'id');
    }

    public function emergenciasReportadas(): HasMany
    {
        return $this->hasMany(Emergencia::class, 'usuarios_id', 'id');
    }

    public function configuraciones(): HasMany
    {
        return $this->hasMany(Configuracion::class, 'usuarios_id', 'id');
    }
}