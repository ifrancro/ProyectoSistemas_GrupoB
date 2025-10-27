<?php

namespace App\Models\Academia;

use Illuminate\Database\Eloquent\Model;

class Capacitacion extends Model
{
    protected $table = 'capacitaciones';
    protected $primaryKey = 'id_capacitacion';
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'rol_destino',
        'estado',
        'total_niveles',
        'puntaje_minimo',
    ];

    protected $casts = [
        'total_niveles' => 'integer',
        'puntaje_minimo' => 'integer',
    ];

    // Relaciones
    public function niveles()
    {
        return $this->hasMany(CapacitacionNivel::class, 'id_capacitacion', 'id_capacitacion')
                    ->orderBy('numero_nivel');
    }

    public function preguntas()
    {
        return $this->hasMany(QuizPregunta::class, 'id_capacitacion', 'id_capacitacion')
                    ->where('activa', true);
    }

    public function progresos()
    {
        return $this->hasMany(ProgresoCapacitacion::class, 'id_capacitacion', 'id_capacitacion');
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('estado', 'ACTIVO');
    }

    public function scopePorRol($query, $rol)
    {
        return $query->where('rol_destino', $rol);
    }
}