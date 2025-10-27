<?php

namespace App\Models\Delegados;

use Illuminate\Database\Eloquent\Model;

class Delegado extends Model
{
    protected $table = 'delegados';
    protected $primaryKey = 'id_delegado';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_persona',
        'id_partido',
        'id_mesa',
        'habilitado',
    ];

    public function persona()
    {
        return $this->belongsTo(\App\Models\Common\Persona::class, 'id_persona', 'id_persona');
    }

    public function partido()
    {
        return $this->belongsTo(\App\Models\Delegados\Partido::class, 'id_partido', 'id_partido');
    }

    public function mesa()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Mesa::class, 'id_mesa', 'id_mesa');
    }
}
