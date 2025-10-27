<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    protected $table = 'asientos';
    protected $primaryKey = 'id_asiento';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_municipio',
    ];

    public function municipio()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Municipio::class, 'id_municipio', 'id_municipio');
    }

    public function recintos()
    {
        return $this->hasMany(\App\Models\Ubicacion\Recinto::class, 'id_asiento', 'id_asiento');
    }
}
