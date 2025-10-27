<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'ci',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'correo',
        'telefono',
        'ciudad',
        'estado',
        'foto_carnet',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'creado_en' => 'datetime',
    ];

    // Relaciones
    public function jurado()
    {
        return $this->hasOne(\App\Models\Jurados\Jurado::class, 'id_persona');
    }

    public function veedor()
    {
        return $this->hasOne(\App\Models\Veedores\Veedor::class, 'id_persona');
    }

    public function delegado()
    {
        return $this->hasOne(\App\Models\Delegados\Delegado::class, 'id_persona');
    }

    public function credenciales()
    {
        return $this->hasMany(\App\Models\Common\Credencial::class, 'id_persona');
    }

    public function historialPersonas()
    {
        return $this->hasMany(\App\Models\Common\HistorialPersona::class, 'id_persona');
    }
}
