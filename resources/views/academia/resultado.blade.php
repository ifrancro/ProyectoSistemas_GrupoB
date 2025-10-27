@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            @if($aprobado)
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-green-600 text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-green-600 mb-2">¡Felicitaciones!</h1>
                <p class="text-gray-600">Has aprobado la evaluación</p>
            @else
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-redo text-red-600 text-3xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-red-600 mb-2">Inténtalo de nuevo</h1>
                <p class="text-gray-600">No has alcanzado el puntaje mínimo</p>
            @endif
        </div>

        <!-- Resultado principal -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full {{ $aprobado ? 'bg-green-100' : 'bg-red-100' }} mb-4">
                    <span class="text-3xl font-bold {{ $aprobado ? 'text-green-600' : 'text-red-600' }}">
                        {{ $puntaje }}%
                    </span>
                </div>
                
                <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                    {{ $capacitacion->titulo }}
                </h2>
                
                <p class="text-gray-600 mb-4">
                    {{ $persona->nombre }} {{ $persona->apellido }} - {{ $persona->ci }}
                </p>
            </div>

            <!-- Detalles del resultado -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">Tu Puntaje</h3>
                    <p class="text-2xl font-bold {{ $aprobado ? 'text-green-600' : 'text-red-600' }}">
                        {{ $puntaje }}%
                    </p>
                </div>
                
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">Puntaje Mínimo</h3>
                    <p class="text-2xl font-bold text-gray-600">
                        {{ $capacitacion->puntaje_minimo }}%
                    </p>
                </div>
                
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-semibold text-gray-900 mb-2">Estado</h3>
                    <p class="text-lg font-bold {{ $aprobado ? 'text-green-600' : 'text-red-600' }}">
                        {{ $aprobado ? 'APROBADO' : 'NO APROBADO' }}
                    </p>
                </div>
            </div>

            <!-- Mensaje según resultado -->
            @if($aprobado)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-green-900 mb-2">¡Excelente trabajo!</h4>
                            <p class="text-green-800 mb-3">
                                Has demostrado un excelente conocimiento sobre tu rol como {{ $capacitacion->rol_destino }}. 
                                Estás completamente capacitado para ejercer tus funciones electorales.
                            </p>
                            <p class="text-green-800 font-medium">
                                Tu certificado de capacitación ha sido registrado en el sistema.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-1 mr-3"></i>
                        <div>
                            <h4 class="font-semibold text-red-900 mb-2">Necesitas repasar el material</h4>
                            <p class="text-red-800 mb-3">
                                Tu puntaje de {{ $puntaje }}% está por debajo del mínimo requerido de {{ $capacitacion->puntaje_minimo }}%. 
                                Te recomendamos revisar nuevamente todos los niveles de capacitación.
                            </p>
                            <p class="text-red-800 font-medium">
                                Puedes volver a realizar el quiz después de repasar el material.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Acciones disponibles -->
        <div class="flex justify-center space-x-4">
            @if($aprobado)
                <a href="{{ route('voluntario.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-certificate mr-2"></i>
                    Ver Mi Credencial
                </a>
            @else
                <a href="{{ route('academia.capacitacion', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-book mr-2"></i>
                    Repasar Material
                </a>
                
                <a href="{{ route('academia.quiz', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                   class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-redo mr-2"></i>
                    Repetir Quiz
                </a>
            @endif
            
            <a href="{{ route('academia.index') }}" 
               class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-home mr-2"></i>
                Volver al Inicio
            </a>
        </div>

        <!-- Información adicional -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Curso</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Curso:</p>
                    <p class="font-semibold text-gray-900">{{ $capacitacion->titulo }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Rol:</p>
                    <p class="font-semibold text-gray-900">{{ $capacitacion->rol_destino }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Fecha de evaluación:</p>
                    <p class="font-semibold text-gray-900">{{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total de preguntas:</p>
                    <p class="font-semibold text-gray-900">{{ $capacitacion->preguntas->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
