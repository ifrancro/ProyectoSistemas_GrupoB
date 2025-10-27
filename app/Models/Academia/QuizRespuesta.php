<?php

namespace App\Models\Academia;

use Illuminate\Database\Eloquent\Model;

class QuizRespuesta extends Model
{
    protected $table = 'quiz_respuestas';
    protected $primaryKey = 'id_respuesta';
    
    protected $fillable = [
        'id_pregunta',
        'opcion',
        'es_correcta',
        'orden',
    ];

    protected $casts = [
        'es_correcta' => 'boolean',
        'orden' => 'integer',
    ];

    // Relaciones
    public function pregunta()
    {
        return $this->belongsTo(QuizPregunta::class, 'id_pregunta', 'id_pregunta');
    }
}
