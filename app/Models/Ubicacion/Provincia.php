<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $primaryKey = 'id_provincia';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'id_departamento',
    ];

    public function departamento()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function municipios()
    {
        return $this->hasMany(\App\Models\Ubicacion\Municipio::class, 'id_provincia', 'id_provincia');
    }
}
