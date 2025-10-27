<?php

namespace App\Http\Controllers\Academia;

use App\Http\Controllers\Controller;
use App\Models\Common\Persona;
use App\Models\Academia\Capacitacion;
use App\Models\Academia\ProgresoCapacitacion;
use Illuminate\Http\Request;

class AcademiaController extends Controller
{
    public function index()
    {
        return view('academia.index');
    }

    public function consultar(Request $request)
    {
        $request->validate(['ci' => 'required|string|min:5|max:15']);
        
        $persona = Persona::where('ci', $request->ci)->first();

        if (!$persona) {
            return back()->with('mensaje', 'CI no válido.');
        }

        if ($persona->estado === 'FALLECIDO') {
            return back()->with('mensaje', 'Persona no apta (fallecida).');
        }

        // Determinar rol
        $rol = null;
        if ($persona->jurado) $rol = 'JURADO';
        elseif ($persona->veedor) $rol = 'VEEDOR';
        elseif ($persona->delegado) $rol = 'DELEGADO';
        
        if (!$rol) {
            return back()->with('mensaje', 'Usted no tiene capacitaciones asignadas.');
        }

        // Buscar capacitación para el rol
        $capacitacion = Capacitacion::activas()->porRol($rol)->first();
        
        if (!$capacitacion) {
            return back()->with('mensaje', 'No hay capacitaciones disponibles para su rol.');
        }

        // Verificar o crear progreso
        $progreso = ProgresoCapacitacion::firstOrCreate(
            [
                'id_persona' => $persona->id_persona,
                'id_capacitacion' => $capacitacion->id_capacitacion,
            ],
            [
                'nivel_actual' => 1,
                'completado' => false,
                'aprobado' => false,
            ]
        );

        return redirect()->route('academia.capacitacion', [
            'ci' => $persona->ci,
            'capacitacion' => $capacitacion->id_capacitacion
        ]);
    }

    public function capacitacion(Request $request)
    {
        $ci = $request->ci;
        $capacitacionId = $request->capacitacion;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('academia.index')->with('mensaje', 'CI no válido.');
        }

        $capacitacion = Capacitacion::with(['niveles', 'preguntas.respuestas'])
            ->findOrFail($capacitacionId);

        $progreso = ProgresoCapacitacion::where('id_persona', $persona->id_persona)
            ->where('id_capacitacion', $capacitacionId)
            ->first();

        if (!$progreso) {
            return redirect()->route('academia.index')->with('mensaje', 'Progreso no encontrado.');
        }

        return view('academia.capacitacion', compact('persona', 'capacitacion', 'progreso'));
    }

    public function nivel(Request $request)
    {
        $ci = $request->ci;
        $capacitacionId = $request->capacitacion;
        $nivelNumero = $request->nivel;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('academia.index')->with('mensaje', 'CI no válido.');
        }

        $capacitacion = Capacitacion::with(['niveles'])->findOrFail($capacitacionId);
        $nivel = $capacitacion->niveles()->where('numero_nivel', $nivelNumero)->first();

        if (!$nivel) {
            return redirect()->route('academia.capacitacion', ['ci' => $ci, 'capacitacion' => $capacitacionId])
                ->with('mensaje', 'Nivel no encontrado.');
        }

        $progreso = ProgresoCapacitacion::where('id_persona', $persona->id_persona)
            ->where('id_capacitacion', $capacitacionId)
            ->first();

        return view('academia.nivel', compact('persona', 'capacitacion', 'nivel', 'progreso'));
    }

    public function completarNivel(Request $request)
    {
        $ci = $request->ci;
        $capacitacionId = $request->capacitacion;
        $nivelNumero = $request->nivel;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('academia.index')->with('mensaje', 'CI no válido.');
        }

        $progreso = ProgresoCapacitacion::where('id_persona', $persona->id_persona)
            ->where('id_capacitacion', $capacitacionId)
            ->first();

        if (!$progreso) {
            return redirect()->route('academia.index')->with('mensaje', 'Progreso no encontrado.');
        }

        $capacitacion = Capacitacion::findOrFail($capacitacionId);

        // Avanzar al siguiente nivel
        $progreso->nivel_actual = $nivelNumero + 1;
        
        // Si completó todos los niveles, marcar como completado
        if ($progreso->nivel_actual > $capacitacion->total_niveles) {
            $progreso->completado = true;
            $progreso->fecha_completado = now();
        }
        
        $progreso->save();

        return redirect()->route('academia.capacitacion', ['ci' => $ci, 'capacitacion' => $capacitacionId])
            ->with('mensaje', 'Nivel completado correctamente.');
    }

    public function quiz(Request $request)
    {
        $ci = $request->ci;
        $capacitacionId = $request->capacitacion;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('academia.index')->with('mensaje', 'CI no válido.');
        }

        $capacitacion = Capacitacion::with(['preguntas.respuestas'])->findOrFail($capacitacionId);
        $progreso = ProgresoCapacitacion::where('id_persona', $persona->id_persona)
            ->where('id_capacitacion', $capacitacionId)
            ->first();

        if (!$progreso || !$progreso->completado) {
            return redirect()->route('academia.capacitacion', ['ci' => $ci, 'capacitacion' => $capacitacionId])
                ->with('mensaje', 'Debe completar todos los niveles antes del quiz.');
        }

        return view('academia.quiz', compact('persona', 'capacitacion', 'progreso'));
    }

    public function evaluarQuiz(Request $request)
    {
        $ci = $request->ci;
        $capacitacionId = $request->capacitacion;

        $persona = Persona::where('ci', $ci)->first();
        if (!$persona) {
            return redirect()->route('academia.index')->with('mensaje', 'CI no válido.');
        }

        $capacitacion = Capacitacion::findOrFail($capacitacionId);
        $progreso = ProgresoCapacitacion::where('id_persona', $persona->id_persona)
            ->where('id_capacitacion', $capacitacionId)
            ->first();

        if (!$progreso) {
            return redirect()->route('academia.index')->with('mensaje', 'Progreso no encontrado.');
        }

        // Calcular puntaje
        $respuestasCorrectas = 0;
        $totalPreguntas = $capacitacion->preguntas()->count();
        
        foreach ($capacitacion->preguntas as $pregunta) {
            $respuestaUsuario = $request->input("pregunta_{$pregunta->id_pregunta}");
            $respuestaCorrecta = $pregunta->respuestas()->where('es_correcta', true)->first();
            
            if ($respuestaUsuario && $respuestaCorrecta && $respuestaUsuario == $respuestaCorrecta->id_respuesta) {
                $respuestasCorrectas++;
            }
        }

        $puntaje = $totalPreguntas > 0 ? round(($respuestasCorrectas / $totalPreguntas) * 100) : 0;
        $aprobado = $puntaje >= $capacitacion->puntaje_minimo;

        // Actualizar progreso
        $progreso->puntaje_quiz = $puntaje;
        $progreso->aprobado = $aprobado;
        $progreso->save();

        return view('academia.resultado', compact('persona', 'capacitacion', 'progreso', 'puntaje', 'aprobado'));
    }
}
