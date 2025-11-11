<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * ⚠️⚠️⚠️ MODELO OBSOLETO - NO USAR ⚠️⚠️⚠️
 * 
 * Este modelo buscaba la tabla 'usuarios' que YA NO EXISTE en el proyecto unificado.
 * 
 * USAR EN SU LUGAR:
 * - App\Models\User (para tabla 'users' - Proyecto Votaciones)
 * - App\Models\Admin\AdminUser (para tabla 'admin_users' - Administradores)
 * - App\Models\Common\Persona (para tabla 'personas' - Proyecto Electoral)
 * 
 * @deprecated Este modelo se mantiene solo por compatibilidad temporal
 */
class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'username',
        'password_hash',
        'rol',
        'remember_token',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected $casts = [
        'creado_en' => 'datetime',
    ];

    // Para compatibilidad con Laravel Auth
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthIdentifierName()
    {
        return 'id_usuario';
    }

    public function getAuthIdentifier()
    {
        return $this->id_usuario;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}