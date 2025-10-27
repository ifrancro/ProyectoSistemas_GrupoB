<?php

namespace App\Models\Academia;

use Illuminate\Database\Eloquent\Model;

class CapacitacionNivel extends Model
{
    protected $table = 'capacitacion_niveles';
    protected $primaryKey = 'id_nivel';
    
    protected $fillable = [
        'id_capacitacion',
        'numero_nivel',
        'titulo',
        'contenido',
        'tipo_contenido',
        'archivo_url',
        'duracion_minutos',
        'requiere_completar',
    ];

    protected $casts = [
        'numero_nivel' => 'integer',
        'duracion_minutos' => 'integer',
        'requiere_completar' => 'boolean',
    ];

    // Relaciones
    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'id_capacitacion', 'id_capacitacion');
    }
}
