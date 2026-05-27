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
        'municipio',
        'departamento',
        'nombre_ganaderia',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'timestamp_registro' => 'datetime',
        'municipio' => 'json',
        'departamento' => 'json',
    ];

    /**
     * Obtiene el nombre de la columna de contraseña para autenticación
     */
    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    // ==================== ACESORES PARA UBICACIÓN ====================

    /**
     * Accesor para municipio - decodifica JSON si es necesario
     */
    public function getMunicipioAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : $value;
        }
        return $value;
    }

    /**
     * Accesor para departamento - decodifica JSON si es necesario
     */
    public function getDepartamentoAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : $value;
        }
        return $value;
    }

    /**
     * Obtiene la ubicación formateada (Municipio, Departamento)
     * Prioriza relaciones sobre campos JSON
     */
    public function getUbicacionFormattedAttribute()
    {
        $municipioText = null;
        $departamentoText = null;

        // Primero intenta obtener de las relaciones (IDs)
        try {
            if ($this->municipio_id && $this->municipioRelacion) {
                $municipioText = $this->municipioRelacion->nombre ?? null;
            }
            
            if ($this->departamento_id && $this->departamentoRelacion) {
                $departamentoText = $this->departamentoRelacion->nombre ?? null;
            }
        } catch (\Exception $e) {
            // Si hay error en las relaciones, continúa con JSON
        }

        // Si no tiene datos de relaciones, intenta desde los campos JSON
        if (!$municipioText || !$departamentoText) {
            $municipio = $this->getAttribute('municipio');
            $departamento = $this->getAttribute('departamento');
            
            // Decodificar si son strings JSON
            if (is_string($municipio)) {
                $municipioDecoded = json_decode($municipio, true);
                if (is_array($municipioDecoded) && isset($municipioDecoded['nombre'])) {
                    $municipioText = $municipioDecoded['nombre'];
                }
            } elseif (is_array($municipio) && isset($municipio['nombre'])) {
                $municipioText = $municipio['nombre'];
            }
            
            if (is_string($departamento)) {
                $departamentoDecoded = json_decode($departamento, true);
                if (is_array($departamentoDecoded) && isset($departamentoDecoded['nombre'])) {
                    $departamentoText = $departamentoDecoded['nombre'];
                }
            } elseif (is_array($departamento) && isset($departamento['nombre'])) {
                $departamentoText = $departamento['nombre'];
            }
        }

        // Retornar ubicación formateada
        if ($municipioText && $departamentoText) {
            return $municipioText . ', ' . $departamentoText;
        }
        
        return 'N/A';
    }

    // ==================== RELACIONES DE LOCALIDAD ====================
    
    public function pais(): BelongsTo
    {
        return $this->belongsTo(Pais::class, 'pais_id', 'id');
    }

    public function departamentoRelacion(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id');
    }

    public function municipioRelacion(): BelongsTo
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
        $rol = strtolower(trim($this->rol ?? ''));
        $rol = preg_replace('/[^a-z0-9]/', '', $rol);
        return $rol === 'productor';
    }

    /**
     * Verifica si el usuario es veterinario
     */
    public function isVeterinario(): bool
    {
        $rol = strtolower(trim($this->rol ?? ''));
        $rol = preg_replace('/[^a-z0-9]/', '', $rol);
        return $rol === 'veterinario';
    }

    /**
     * Verifica si el usuario es especialista
     */
    public function isEspecialista(): bool
    {
        $rol = strtolower(trim($this->rol ?? ''));
        $rol = preg_replace('/[^a-z0-9]/', '', $rol);
        return $rol === 'especialista';
    }

    /**
     * Verifica si el usuario es profesional (veterinario o especialista)
     */
    public function isProfesional(): bool
    {
        $rol = strtolower(trim($this->rol ?? ''));
        $rol = preg_replace('/[^a-z0-9]/', '', $rol);
        return in_array($rol, ['veterinario', 'especialista']);
    }

    /**
     * Verifica si el usuario está activo
     */
    public function isActivo(): bool
    {
        return $this->estado === 'A';
    }
}