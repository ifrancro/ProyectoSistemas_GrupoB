@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $departamento->nombre }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.ubicacion.departamentos.edit', $departamento) }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <a href="{{ route('admin.ubicacion.departamentos.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Información del Departamento -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 text-sm font-medium">ID del Departamento</div>
                    <div class="text-2xl font-bold text-blue-800">{{ $departamento->id_departamento }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 text-sm font-medium">Provincias</div>
                    <div class="text-2xl font-bold text-green-800">{{ $departamento->provincias->count() }}</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-purple-600 text-sm font-medium">Municipios</div>
                    <div class="text-2xl font-bold text-purple-800">
                        {{ $departamento->provincias->sum(function($provincia) { return $provincia->municipios->count(); }) }}
                    </div>
                </div>
            </div>

            <!-- Provincias del Departamento -->
            @if($departamento->provincias->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Provincias</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($departamento->provincias as $provincia)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800">{{ $provincia->nombre }}</h3>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                {{ $provincia->municipios->count() }} municipios
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div class="mb-1">
                                <strong>Municipios:</strong>
                                @if($provincia->municipios->count() > 0)
                                    {{ $provincia->municipios->pluck('nombre')->join(', ') }}
                                @else
                                    Sin municipios
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-map text-4xl mb-4"></i>
                <p>Este departamento no tiene provincias registradas.</p>
                <a href="{{ route('admin.ubicacion.provincias.create') }}" 
                   class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    <i class="fas fa-plus mr-2"></i>Agregar primera provincia
                </a>
            </div>
            @endif

            <!-- Navegación rápida -->
            <div class="mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('admin.ubicacion.departamentos.index') }}" 
                   class="bg-blue-100 text-blue-800 p-4 rounded-lg text-center hover:bg-blue-200 transition-colors">
                    <i class="fas fa-building text-2xl mb-2"></i>
                    <div class="font-semibold">Departamentos</div>
                </a>
                <a href="{{ route('admin.ubicacion.provincias.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-map text-2xl mb-2"></i>
                    <div class="font-semibold">Provincias</div>
                </a>
                <a href="{{ route('admin.ubicacion.municipios.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-city text-2xl mb-2"></i>
                    <div class="font-semibold">Municipios</div>
                </a>
                <a href="{{ route('admin.ubicacion.asientos.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-map-marker text-2xl mb-2"></i>
                    <div class="font-semibold">Asientos</div>
                </a>
                <a href="{{ route('admin.ubicacion.recintos.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-school text-2xl mb-2"></i>
                    <div class="font-semibold">Recintos</div>
                </a>
                <a href="{{ route('admin.ubicacion.mesas.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
                    <i class="fas fa-table text-2xl mb-2"></i>
                    <div class="font-semibold">Mesas</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
