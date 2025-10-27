@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Nivel {{ $nivel->numero_nivel }}</h1>
            <p class="text-gray-600">{{ $nivel->titulo }}</p>
        </div>

        <!-- Información del nivel -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">{{ $nivel->titulo }}</h2>
                @if($nivel->duracion_minutos)
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        <i class="fas fa-clock mr-1"></i>{{ $nivel->duracion_minutos }} min
                    </span>
                @endif
            </div>

            <!-- Contenido del nivel -->
            <div class="prose max-w-none">
                {!! nl2br(e($nivel->contenido)) !!}
            </div>

            @if($nivel->archivo_url)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-semibold text-gray-900 mb-2">Material Adicional</h4>
                    
                    @if(str_contains($nivel->archivo_url, 'youtu.be') || str_contains($nivel->archivo_url, 'youtube.com'))
                        <!-- Video de YouTube -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-3">Video complementario:</p>
                            <div class="relative w-full" style="padding-bottom: 56.25%;">
                                <iframe 
                                    class="absolute top-0 left-0 w-full h-full rounded-lg"
                                    src="{{ str_replace('youtu.be/', 'youtube.com/embed/', str_replace('watch?v=', 'embed/', $nivel->archivo_url)) }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                        <div class="text-center">
                            <a href="{{ $nivel->archivo_url }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fab fa-youtube mr-2"></i>
                                Ver en YouTube
                            </a>
                        </div>
                    @else
                        <!-- Otros tipos de archivo -->
                        <a href="{{ $nivel->archivo_url }}" target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-download mr-2"></i>
                            Descargar Material
                        </a>
                    @endif
                </div>
            @endif

            @if(str_contains($nivel->contenido, 'MATERIAL AUDIOVISUAL') && str_contains($nivel->contenido, 'Video 2:'))
                <!-- Videos adicionales mencionados en el contenido -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <h4 class="font-semibold text-blue-900 mb-2">Videos Adicionales</h4>
                    <p class="text-sm text-blue-700 mb-4">Este nivel incluye videos adicionales mencionados en el contenido:</p>
                    
                    @if($nivel->numero_nivel == 3 && $capacitacion->rol_destino == 'JURADO')
                        <!-- Videos adicionales para Nivel 3 de Jurados -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-blue-800 mb-2">Video 1: Gestión de Incidentes Electorales</p>
                                <div class="relative w-full" style="padding-bottom: 56.25%;">
                                    <iframe 
                                        class="absolute top-0 left-0 w-full h-full rounded-lg"
                                        src="https://youtube.com/embed/OZQgXJD3fdc"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="mt-2 text-center">
                                    <a href="https://youtu.be/OZQgXJD3fdc" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors">
                                        <i class="fab fa-youtube mr-1"></i>
                                        Ver en YouTube
                                    </a>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-800 mb-2">Video 2: Ética y Transparencia</p>
                                <div class="relative w-full" style="padding-bottom: 56.25%;">
                                    <iframe 
                                        class="absolute top-0 left-0 w-full h-full rounded-lg"
                                        src="https://youtube.com/embed/89wnauanqaQ"
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="mt-2 text-center">
                                    <a href="https://youtu.be/89wnauanqaQ" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700 transition-colors">
                                        <i class="fab fa-youtube mr-1"></i>
                                        Ver en YouTube
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Navegación -->
        <div class="flex justify-between items-center">
            <div class="flex space-x-4">
                @if($nivel->numero_nivel > 1)
                    <a href="{{ route('academia.nivel', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion, 'nivel' => $nivel->numero_nivel - 1]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Nivel Anterior
                    </a>
                @endif
                
                <a href="{{ route('academia.capacitacion', ['ci' => $persona->ci, 'capacitacion' => $capacitacion->id_capacitacion]) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-list mr-2"></i>
                    Ver Todos los Niveles
                </a>
            </div>

            <div>
                @if($nivel->numero_nivel < $capacitacion->total_niveles)
                    <form action="{{ route('academia.completar-nivel') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="ci" value="{{ $persona->ci }}">
                        <input type="hidden" name="capacitacion" value="{{ $capacitacion->id_capacitacion }}">
                        <input type="hidden" name="nivel" value="{{ $nivel->numero_nivel }}">
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
                                onclick="return confirm('¿Has terminado de leer este nivel?')">
                            <i class="fas fa-check mr-2"></i>
                            Completar Nivel
                        </button>
                    </form>
                @else
                    <form action="{{ route('academia.completar-nivel') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="ci" value="{{ $persona->ci }}">
                        <input type="hidden" name="capacitacion" value="{{ $capacitacion->id_capacitacion }}">
                        <input type="hidden" name="nivel" value="{{ $nivel->numero_nivel }}">
                        
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors"
                                onclick="return confirm('¿Has terminado de leer el último nivel? Esto te habilitará para el quiz final.')">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Finalizar Curso
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Progreso -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Progreso del Curso</h3>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-700">Nivel {{ $nivel->numero_nivel }} de {{ $capacitacion->total_niveles }}</span>
                <span class="text-sm text-gray-500">{{ round(($nivel->numero_nivel / $capacitacion->total_niveles) * 100) }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-purple-600 h-2 rounded-full" style="width: {{ ($nivel->numero_nivel / $capacitacion->total_niveles) * 100 }}%"></div>
            </div>
        </div>
    </div>
</div>
@endsection
