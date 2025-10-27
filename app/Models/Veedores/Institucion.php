<?php

namespace App\Models\Veedores;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    protected $table = 'instituciones';
    protected $primaryKey = 'id_institucion';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'sigla',
    ];

    // Especificar qué campo usar para el modelo binding
    public function getRouteKeyName()
    {
        return 'id_institucion';
    }
}
