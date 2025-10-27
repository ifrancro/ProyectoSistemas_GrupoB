<?php

namespace App\Models\Ubicacion;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $table = 'mesas';
    protected $primaryKey = 'id_mesa';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'id_recinto',
    ];

    public function recinto()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Recinto::class, 'id_recinto', 'id_recinto');
    }

    public function jurados()
    {
        return $this->hasMany(\App\Models\Jurados\Jurado::class, 'id_mesa', 'id_mesa');
    }

    public function delegados()
    {
        return $this->hasMany(\App\Models\Delegados\Delegado::class, 'id_mesa', 'id_mesa');
    }
}
