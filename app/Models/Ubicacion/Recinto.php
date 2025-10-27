<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Recinto extends Model
{
    protected $table = 'recintos';
    protected $primaryKey = 'id_recinto';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'direccion',
        'id_asiento',
    ];

    public function asiento()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Asiento::class, 'id_asiento', 'id_asiento');
    }

    public function mesas()
    {
        return $this->hasMany(\App\Models\Ubicacion\Mesa::class, 'id_recinto', 'id_recinto');
    }
}
