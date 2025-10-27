<?php

namespace App\Models\Academia;

use Illuminate\Database\Eloquent\Model;

class QuizPregunta extends Model
{
    protected $table = 'quiz_preguntas';
    protected $primaryKey = 'id_pregunta';
    
    protected $fillable = [
        'id_capacitacion',
        'pregunta',
        'tipo',
        'puntos',
        'activa',
    ];

    protected $casts = [
        'puntos' => 'integer',
        'activa' => 'boolean',
    ];

    // Relaciones
    public function capacitacion()
    {
        return $this->belongsTo(Capacitacion::class, 'id_capacitacion', 'id_capacitacion');
    }

    public function respuestas()
    {
        return $this->hasMany(QuizRespuesta::class, 'id_pregunta', 'id_pregunta')
                    ->orderBy('orden');
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }
}
