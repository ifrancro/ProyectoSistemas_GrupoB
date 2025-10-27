<?php

namespace App\Models\Jurados;

use Illuminate\Database\Eloquent\Model;

class Jurado extends Model
{
    protected $table = 'jurados';
    protected $primaryKey = 'id_jurado';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_mesa',
        'cargo',
        'verificado',
    ];

    public function persona()
    {
        return $this->belongsTo(\App\Models\Common\Persona::class, 'id_persona', 'id_persona');
    }

    public function mesa()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Mesa::class, 'id_mesa', 'id_mesa');
    }
}
