<?php

namespace App\Models\Academia;

use Illuminate\Database\Eloquent\Model;

class ProgresoCapacitacion extends Model
{
    protected $table = 'progreso_capacitaciones';
    protected $primaryKey = 'id_progreso';
    
    protected $fillable = [
        'id_persona',
        'id_capacitacion',
        'nivel_actual',
        'completado',
        'puntaje_quiz',
        'aprobado',
        'fecha_inicio',
        'fecha_completado',
    ];

    protected $casts = [
        'nivel_actual' => 'integer',
        'completado' => 'boolean',
        'puntaje_quiz' => 'integer',
        'aprobado' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_completado' => 'datetime',
    ];

    // Relaciones
    public function persona()
    {
        return $this->belongsTo(\App\Models\Common\Persona::class, 'id_persona', 'id_persona');
    }

    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'id_capacitacion', 'id_capacitacion');
    }
}
