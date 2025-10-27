@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4
                @if($veedor->estado == 'APROBADO') bg-green-100
                @elseif($veedor->estado == 'RECHAZADO') bg-red-100
                @else bg-yellow-100 @endif">
                <svg class="w-8 h-8 
                    @if($veedor->estado == 'APROBADO') text-green-600
                    @elseif($veedor->estado == 'RECHAZADO') text-red-600
                    @else text-yellow-600 @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($veedor->estado == 'APROBADO')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    @elseif($veedor->estado == 'RECHAZADO')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    @endif
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                @if($veedor->estado == 'APROBADO')
                    ¡Solicitud Aprobada!
                @elseif($veedor->estado == 'RECHAZADO')
                    Solicitud Rechazada
                @else
                    Solicitud en Revisión
                @endif
            </h1>
            <p class="text-lg text-gray-600">
                {{ $persona->nombre }} {{ $persona->apellido }}
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            @if($veedor->estado == 'PENDIENTE')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-yellow-800">Su solicitud está en revisión</h3>
                            <p class="text-yellow-700 mt-1">
                                Su solicitud como veedor está siendo evaluada por el administrador. 
                                Recibirá una notificación cuando sea procesada.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($veedor->estado == 'RECHAZADO')
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-red-800">Solicitud rechazada</h3>
                            <p class="text-red-700 mt-1">
                                @if($veedor->motivo_rechazo)
                                    <strong>Motivo:</strong> {{ $veedor->motivo_rechazo }}
                                @else
                                    Su solicitud como veedor ha sido rechazada.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($veedor->estado == 'APROBADO')
                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-green-800">¡Solicitud aprobada!</h3>
                            <p class="text-green-700 mt-1">
                                Su solicitud como veedor ha sido aprobada. Ya puede ejercer sus funciones.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Información Personal -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Información Personal</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-medium">{{ $persona->nombre }} {{ $persona->apellido }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">CI:</span>
                            <span class="font-medium">{{ $persona->ci }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Institución:</span>
                            <span class="font-medium">{{ $veedor->institucion->nombre }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Estado:</span>
                            <span class="font-medium px-2 py-1 rounded text-sm
                                @if($veedor->estado == 'APROBADO') bg-green-100 text-green-800
                                @elseif($veedor->estado == 'RECHAZADO') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $veedor->estado }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Documentos -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Documentos</h2>
                    <div class="space-y-3">
                        @if($veedor->carta_respaldo)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Carta de Respaldo</span>
                                </div>
                                <a href="{{ asset($veedor->carta_respaldo) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Ver
                                </a>
                            </div>
                        @endif

                        @if($veedor->foto_carnet)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm text-gray-700">Foto de Carnet</span>
                                </div>
                                <a href="{{ asset($veedor->foto_carnet) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Ver
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($veedor->estado == 'APROBADO')
                <!-- Botón de Credencial -->
                <div class="mt-8 text-center">
                    <a href="#" 
                       class="inline-flex items-center px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Descargar Credencial
                    </a>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('voluntario.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium">
                ← Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection
