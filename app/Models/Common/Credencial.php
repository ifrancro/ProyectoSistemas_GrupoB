<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class Credencial extends Model
{
    protected $table = 'credenciales';
    protected $primaryKey = 'id_credencial';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'rol',
        'qr_code',
        'pdf_path',
        'emitido_en',
    ];

    protected $casts = [
        'emitido_en' => 'datetime',
    ];

    // Relaciones
    public function persona()
    {
        return $this->belongsTo(\App\Models\Common\Persona::class, 'id_persona', 'id_persona');
    }

    // Scopes
    public function scopeGeneradas($query)
    {
        return $query->whereNotNull('pdf_path');
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }
}
