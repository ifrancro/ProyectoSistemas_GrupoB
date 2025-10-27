@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-gavel text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Consulta de Jurado</h1>
            <p class="text-gray-600">Información de su asignación como jurado electoral</p>
        </div>

        <!-- Información del Ciudadano -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user mr-2 text-blue-600"></i>
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

        <!-- Información del Rol -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-gavel mr-2 text-blue-600"></i>
                Asignación como Jurado
            </h2>
            
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    <p class="text-blue-800 font-medium">
                        {{ $persona->nombre }} {{ $persona->apellido }} puede ver su recinto y descargar su credencial.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cargo Asignado</label>
                    <div class="mt-1">
                        @if($jurado->cargo == 'PRESIDENTE')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-crown mr-1"></i>PRESIDENTE
                            </span>
                        @elseif($jurado->cargo == 'SECRETARIO')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-pen mr-1"></i>SECRETARIO
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-user mr-1"></i>VOCAL
                            </span>
                        @endif
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado de Verificación</label>
                    <div class="mt-1">
                        @if($jurado->verificado)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>VERIFICADO
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-clock mr-1"></i>PENDIENTE
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Ubicación Asignada -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>
                Ubicación Asignada
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mesa Electoral</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Mesa {{ $jurado->mesa->numero }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Recinto</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jurado->mesa->recinto->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Asiento Electoral</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jurado->mesa->recinto->asiento->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Municipio</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jurado->mesa->recinto->asiento->municipio->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Provincia</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jurado->mesa->recinto->asiento->municipio->provincia->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departamento</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $jurado->mesa->recinto->asiento->municipio->provincia->departamento->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-download mr-2 text-blue-600"></i>
                Descargar Credencial
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('vol.descargar-credencial', ['ci' => $persona->ci, 'rol' => 'JURADO']) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Visualizar Credencial (PDF)
                </a>
                
                <a href="{{ route('voluntario.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Consulta
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
