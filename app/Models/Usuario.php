<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre_completo',
        'documento',
        'telefono',
        'email',
        'direccion',
        'rol',
        'especialidad',
        'tarjeta_profesional',
        'estado',
        'registrado_por',
        'timestamp_registro',
        'password_hash',
    ];

    protected $casts = [
        'timestamp_registro' => 'datetime',
    ];

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