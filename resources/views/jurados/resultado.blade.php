@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">¡Asignación Encontrada!</h1>
            <p class="text-lg text-gray-600">
                {{ $persona->nombre }} {{ $persona->apellido }} puede ver su recinto y descargar su credencial.
            </p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
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
                            <span class="text-gray-600">Cargo:</span>
                            <span class="font-medium bg-pink-100 text-pink-800 px-2 py-1 rounded">{{ $jurado->cargo }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ubicación Asignada -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ubicación Asignada</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Mesa:</span>
                            <span class="font-medium">{{ $mesa->numero }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Recinto:</span>
                            <span class="font-medium">{{ $recinto->nombre }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dirección:</span>
                            <span class="font-medium">{{ $recinto->direccion }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botón de Credencial -->
            <div class="mt-8 text-center">
                <a href="#" 
                   class="inline-flex items-center px-6 py-3 bg-pink-600 text-white font-semibold rounded-lg hover:bg-pink-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Visualizar Credencial (QR/PDF)
                </a>
            </div>

            <!-- Información adicional -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800">Información Importante</h3>
                        <p class="text-sm text-blue-700 mt-1">
                            Presente su credencial el día de las elecciones en el recinto asignado. 
                            Su cargo es <strong>{{ $jurado->cargo }}</strong> de la Mesa {{ $mesa->numero }}.
                        </p>
                    </div>
                </div>
            </div>
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
