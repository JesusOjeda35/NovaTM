<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ USAR LA TABLA 'users' (como está en la BD)
    protected $table = 'users';
    
    // La columna de clave primaria es 'id'
    protected $primaryKey = 'id';
    
    // Desactivar timestamps automáticos (usamos timestamp_registro)
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
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'timestamp_registro' => 'datetime',
    ];

    /**
     * Obtiene el nombre de la columna de contraseña para autenticación
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    // ==================== RELACIONES DE LOCALIDAD ====================
    
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id');
    }

    // ==================== RELACIONES PRINCIPALES ====================
    
    public function animales(): HasMany
    {
        return $this->hasMany(Animal::class, 'user_id', 'id');
    }

    public function consultas(): HasMany
    {
        return $this->hasMany(Consulta::class, 'user_id', 'id');
    }

    public function historialesClinicos(): HasMany
    {
        return $this->hasMany(HistorialClinico::class, 'user_id', 'id');
    }

    public function recetas(): HasMany
    {
        return $this->hasMany(Receta::class, 'user_id', 'id');
    }

    // ==================== RELACIONES DE MENSAJES ====================
    
    public function mensajesEnviados(): HasMany
    {
        return $this->hasMany(Mensajes::class, 'user_id', 'id');
    }

    public function mensajesRecibidos(): HasMany
    {
        return $this->hasMany(Mensajes::class, 'user_id2', 'id');
    }

    // ==================== RELACIONES DE NOTIFICACIONES Y EMERGENCIAS ====================
    
    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificaciones::class, 'user_id', 'id');
    }

    public function emergenciasReportadas(): HasMany
    {
        return $this->hasMany(Emergencias::class, 'user_id', 'id');
    }

    public function emergenciasAtendidas(): HasMany
    {
        return $this->hasMany(Emergencias::class, 'user_id2', 'id');
    }

    public function configuraciones(): HasMany
    {
        return $this->hasMany(Configuracion::class, 'user_id', 'id');
    }

    // ==================== RELACIÓN CON DISPONIBILIDADES ====================

    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'user_id', 'id');
    }

    // ==================== MÉTODOS HELPER ====================

    /**
     * Verifica si el usuario es productor
     */
    public function isProductor(): bool
    {
        return $this->rol === 'productor';
    }

    /**
     * Verifica si el usuario es veterinario
     */
    public function isVeterinario(): bool
    {
        return $this->rol === 'veterinario';
    }

    /**
     * Verifica si el usuario es especialista
     */
    public function isEspecialista(): bool
    {
        return $this->rol === 'especialista';
    }

    /**
     * Verifica si el usuario es profesional (veterinario o especialista)
     */
    public function isProfesional(): bool
    {
        return in_array($this->rol, ['veterinario', 'especialista']);
    }

    /**
     * Verifica si el usuario está activo
     */
    public function isActivo(): bool
    {
        return $this->estado === 'A';
    }
}