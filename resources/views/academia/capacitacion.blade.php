@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-graduation-cap text-purple-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Academia Electoral</h1>
            <p class="text-gray-600">Capacitación para {{ $persona->nombre }} {{ $persona->apellido }}</p>
        </div>

        @if(session('mensaje'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check mr-2"></i>
                    {{ session('mensaje') }}
                </div>
            </div>
        @endif

        <!-- Información del curso -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-semibold text-gray-900">{{ $capacitacion->titulo }}</h2>
                <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $capacitacion->rol_destino }}
                </span>
            </div>
            
            @if($capacitacion->descripcion)
                <p class="text-gray-700 mb-4">{{ $capacitacion->descripcion }}</p>
            @endif

            <!-- Progreso -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Progreso del curso</span>
                    <span class="text-sm text-gray-500">{{ $progreso->nivel_actual }} / {{ $capacitacion->total_niveles }} niveles</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($progreso->nivel_actual - 1) / $capacitacion->total_niveles * 100 }}%"></div>
                </div>
            </div>

            <!-- Estado -->
            <div class="flex items-center space-x-4">
                @if($progreso->completado)
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-check mr-1"></i>Curso Completado
                    </span>
                @else
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-play mr-1"></i>En Progreso
                    </span>
                @endif

                @if($progreso->aprobado)
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-trophy mr-1"></i>Certificado
                    </span>
                @elseif($progreso->puntaje_quiz !== null)
                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-redo mr-1"></i>Repetir Quiz
                    </span>
                @endif
            </div>
        </div>

        <!-- Niveles del curso -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Niveles de Capacitación</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($capacitacion->niveles as $nivel)
                    <div class="border rounded-lg p-4 {{ $nivel->numero_nivel <= $progreso->nivel_actual ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-semibold text-gray-900">Nivel {{ $nivel->numero_nivel }}</h4>
                            @if($nivel->numero_nivel < $progreso->nivel_actual)
                                <i class="fas fa-check-circle text-green-600"></i>
                            @elseif($nivel->numero_nivel == $progreso->nivel_actual)
                                <i class="fas fa-play-circle text-blue-600"></i>
                            @else
                                <i class="fas fa-lock text-gray-400"></i>
                            @endif
                        </div>
                        
                        <h5 class="text-sm font-medium text-gray-700 mb-2">{{ $nivel->titulo }}</h5>
                        
                        @if($nivel->duracion_minutos)
                            <p class="text-xs text-gray-500 mb-3">
                                <i class="fas fa-clock mr-1"></i>{{ $nivel->duracion_minutos }} minutos
                            </p>
                        @endif

                        @if($nivel->numero_nivel <= $progreso->nivel_actual)
                            <a href="{{ route('academia.nivel', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion, 'nivel' => $nivel->numero_nivel]) }}" 
                               class="inline-flex items-center px-3 py-1 bg-purple-600 text-white rounded text-sm hover:bg-purple-700 transition-colors">
                                @if($nivel->numero_nivel < $progreso->nivel_actual)
                                    <i class="fas fa-eye mr-1"></i>Ver
                                @else
                                    <i class="fas fa-play mr-1"></i>Continuar
                                @endif
                            </a>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-gray-300 text-gray-500 rounded text-sm">
                                <i class="fas fa-lock mr-1"></i>Bloqueado
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Quiz -->
        @if($progreso->completado)
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Evaluación Final</h3>
                
                @if($progreso->puntaje_quiz === null)
                    <p class="text-gray-700 mb-4">¡Felicidades! Has completado todos los niveles. Ahora puedes realizar la evaluación final.</p>
                    <a href="{{ route('academia.quiz', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-question-circle mr-2"></i>
                        Realizar Quiz
                    </a>
                @else
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-700 mb-2">Último puntaje obtenido: <span class="font-semibold">{{ $progreso->puntaje_quiz }}%</span></p>
                            <p class="text-sm text-gray-500">Puntaje mínimo requerido: {{ $capacitacion->puntaje_minimo }}%</p>
                        </div>
                        <a href="{{ route('academia.quiz', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-redo mr-2"></i>
                            Repetir Quiz
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <!-- Acciones -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('academia.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver al Inicio
            </a>
            
            @if($progreso->aprobado)
                <a href="{{ route('voluntario.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-certificate mr-2"></i>
                    Ver Credencial
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
