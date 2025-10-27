@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-question-circle text-yellow-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Evaluación Final</h1>
            <p class="text-gray-600">{{ $capacitacion->titulo }}</p>
        </div>

        <!-- Información del quiz -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Quiz de Evaluación</h2>
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $capacitacion->preguntas->count() }} preguntas
                </span>
            </div>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                    <div>
                        <h4 class="font-semibold text-blue-900 mb-2">Instrucciones:</h4>
                        <ul class="text-blue-800 text-sm space-y-1">
                            <li>• Lee cada pregunta cuidadosamente</li>
                            <li>• Selecciona la respuesta que consideres correcta</li>
                            <li>• Necesitas obtener al menos {{ $capacitacion->puntaje_minimo }}% para aprobar</li>
                            <li>• Puedes repetir el quiz si no apruebas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario del quiz -->
        <form action="{{ route('academia.evaluar-quiz') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="ci" value="{{ $persona->ci }}">
            <input type="hidden" name="capacitacion" value="{{ $capacitacion->id_capacitacion }}">

            @foreach($capacitacion->preguntas as $index => $pregunta)
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-start mb-4">
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium mr-4">
                            {{ $index + 1 }}
                        </span>
                        <h3 class="text-lg font-semibold text-gray-900 flex-1">{{ $pregunta->pregunta }}</h3>
                    </div>

                    <div class="space-y-3">
                        @foreach($pregunta->respuestas as $respuesta)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" 
                                       name="pregunta_{{ $pregunta->id_pregunta }}" 
                                       value="{{ $respuesta->id_respuesta }}"
                                       class="mr-3 text-purple-600 focus:ring-purple-500">
                                <span class="text-gray-700">{{ $respuesta->opcion }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Botones de acción -->
            <div class="flex justify-between items-center bg-white rounded-lg shadow-lg p-6">
                <a href="{{ route('academia.capacitacion', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                   class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Curso
                </a>

                <button type="submit" 
                        class="inline-flex items-center px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold"
                        onclick="return confirm('¿Estás seguro de que quieres enviar tus respuestas?')">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar Respuestas
                </button>
            </div>
        </form>

        <!-- Información adicional -->
        <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Estudiante</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nombre:</p>
                    <p class="font-semibold text-gray-900">{{ $persona->nombre }} {{ $persona->apellido }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">CI:</p>
                    <p class="font-semibold text-gray-900">{{ $persona->ci }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Rol:</p>
                    <p class="font-semibold text-gray-900">{{ $capacitacion->rol_destino }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Puntaje mínimo:</p>
                    <p class="font-semibold text-gray-900">{{ $capacitacion->puntaje_minimo }}%</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
