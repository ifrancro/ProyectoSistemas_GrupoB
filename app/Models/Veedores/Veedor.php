<?php

namespace App\Models\Veedores;

use Illuminate\Database\Eloquent\Model;

class Veedor extends Model
{
    protected $table = 'veedores';
    protected $primaryKey = 'id_veedor';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_institucion',
        'carta_respaldo',
        'estado',
        'motivo_rechazo',
    ];

    public function persona()
    {
        return $this->belongsTo(\App\Models\Common\Persona::class, 'id_persona', 'id_persona');
    }

    public function institucion()
    {
        return $this->belongsTo(\App\Models\Veedores\Institucion::class, 'id_institucion', 'id_institucion');
    }
}
