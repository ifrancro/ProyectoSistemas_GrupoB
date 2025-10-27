<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'departamentos';
    protected $primaryKey = 'id_departamento';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function provincias()
    {
        return $this->hasMany(\App\Models\Ubicacion\Provincia::class, 'id_departamento', 'id_departamento');
    }
}
