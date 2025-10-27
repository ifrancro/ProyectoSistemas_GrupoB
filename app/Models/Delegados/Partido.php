<?php

namespace App\Models\Delegados;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $table = 'partidos';
    protected $primaryKey = 'id_partido';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'sigla',
        'nombre',
        'estado',
        'logo_url',
    ];
}
