<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $primaryKey = 'id_municipio';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_provincia',
    ];

    public function provincia()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Provincia::class, 'id_provincia', 'id_provincia');
    }

    public function asientos()
    {
        return $this->hasMany(\App\Models\Ubicacion\Asiento::class, 'id_municipio', 'id_municipio');
    }
}
