@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-eye text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Consulta de Veedor</h1>
            <p class="text-gray-600">Estado de su solicitud como veedor electoral</p>
        </div>

        <!-- Información del Ciudadano -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user mr-2 text-green-600"></i>
                Información Personal
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cédula de Identidad</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $persona->ci }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $persona->nombre }} {{ $persona->apellido }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $persona->ciudad ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $persona->estado ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Estado de la Solicitud -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-eye mr-2 text-green-600"></i>
                Estado de Solicitud como Veedor
            </h2>
            
            @if($veedor->estado == 'PENDIENTE')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-yellow-600 mr-2"></i>
                        <p class="text-yellow-800 font-medium">
                            Su solicitud está en revisión. El administrador evaluará su documentación.
                        </p>
                    </div>
                </div>
            @elseif($veedor->estado == 'RECHAZADO')
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-times text-red-600 mr-2"></i>
                        <p class="text-red-800 font-medium">
                            Solicitud rechazada.
                        </p>
                    </div>
                    @if($veedor->motivo_rechazo)
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-red-700">Motivo del rechazo:</label>
                            <p class="mt-1 text-sm text-red-600 bg-red-50 p-3 rounded border">
                                {{ $veedor->motivo_rechazo }}
                            </p>
                        </div>
                    @endif
                </div>
            @elseif($veedor->estado == 'APROBADO')
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check text-green-600 mr-2"></i>
                        <p class="text-green-800 font-medium">
                            ¡Felicidades! Su solicitud ha sido aprobada. Ya puede descargar su credencial.
                        </p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Institución</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $veedor->institucion->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <div class="mt-1">
                        @if($veedor->estado == 'PENDIENTE')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>PENDIENTE
                            </span>
                        @elseif($veedor->estado == 'APROBADO')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>APROBADO
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i>RECHAZADO
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-download mr-2 text-green-600"></i>
                Acciones Disponibles
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-4">
                @if($veedor->estado == 'APROBADO')
                    <a href="{{ route('vol.descargar-credencial', ['ci' => $persona->ci, 'rol' => 'VEEDOR']) }}" 
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Descargar Credencial (PDF)
                    </a>
                @endif
                
                <a href="{{ route('voluntario.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Consulta
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
