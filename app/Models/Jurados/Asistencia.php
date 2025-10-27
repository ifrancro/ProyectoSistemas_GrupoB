<?php

namespace App\Models\Jurados;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia';
    protected $primaryKey = 'id_asistencia';
    
    // Deshabilitar timestamps automáticos de Laravel
    public $timestamps = false;

    protected $fillable = [
        'id_jurado',
        'id_mesa',
        'estado',
        'registrado_en',
    ];

    protected $casts = [
        'registrado_en' => 'datetime',
    ];

    public function jurado()
    {
        return $this->belongsTo(\App\Models\Jurados\Jurado::class, 'id_jurado', 'id_jurado');
    }

    public function mesa()
    {
        return $this->belongsTo(\App\Models\Ubicacion\Mesa::class, 'id_mesa', 'id_mesa');
    }
}
