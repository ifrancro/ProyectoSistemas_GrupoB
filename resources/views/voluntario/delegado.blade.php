@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-tie text-purple-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Consulta de Delegado</h1>
            <p class="text-gray-600">Información de su asignación como delegado electoral</p>
        </div>

        <!-- Información del Ciudadano -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user mr-2 text-purple-600"></i>
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
                <i class="fas fa-user-tie mr-2 text-purple-600"></i>
                Asignación como Delegado
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Partido Político</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                            <i class="fas fa-flag mr-1"></i>{{ $delegado->partido->nombre }}
                        </span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado</label>
                    <div class="mt-1">
                        @if($delegado->habilitado)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>HABILITADO
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times mr-1"></i>NO HABILITADO
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Mesa Asignada -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt mr-2 text-purple-600"></i>
                Mesa Asignada
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mesa Electoral</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Mesa {{ $delegado->mesa->numero }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Recinto</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $delegado->mesa->recinto->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Asiento Electoral</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $delegado->mesa->recinto->asiento->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Municipio</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $delegado->mesa->recinto->asiento->municipio->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Provincia</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $delegado->mesa->recinto->asiento->municipio->provincia->nombre }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Departamento</label>
                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $delegado->mesa->recinto->asiento->municipio->provincia->departamento->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-download mr-2 text-purple-600"></i>
                Descargar Credencial
            </h2>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('vol.descargar-credencial', ['ci' => $persona->ci, 'rol' => 'DELEGADO']) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    <i class="fas fa-file-pdf mr-2"></i>
                    Descargar Credencial (PDF)
                </a>
                
                <a href="{{ route('voluntario.index') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Consulta
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
