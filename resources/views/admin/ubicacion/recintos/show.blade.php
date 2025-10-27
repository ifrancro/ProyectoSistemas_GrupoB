@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-800">{{ $recinto->nombre }}</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.ubicacion.recintos.edit', $recinto) }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>Editar
                    </a>
                    <a href="{{ route('admin.ubicacion.recintos.index') }}" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>

            <!-- Información del Recinto -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-blue-600 text-sm font-medium">ID del Recinto</div>
                    <div class="text-2xl font-bold text-blue-800">{{ $recinto->id_recinto }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-green-600 text-sm font-medium">Asiento</div>
                    <div class="text-2xl font-bold text-green-800">{{ $recinto->asiento->nombre }}</div>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="text-purple-600 text-sm font-medium">Municipio</div>
                    <div class="text-2xl font-bold text-purple-800">{{ $recinto->asiento->municipio->nombre }}</div>
                </div>
                <div class="bg-orange-50 p-4 rounded-lg">
                    <div class="text-orange-600 text-sm font-medium">Provincia</div>
                    <div class="text-2xl font-bold text-orange-800">{{ $recinto->asiento->municipio->provincia->nombre }}</div>
                </div>
            </div>

            @if($recinto->direccion)
            <div class="mb-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="text-gray-600 text-sm font-medium">Dirección</div>
                    <div class="text-lg font-semibold text-gray-800">{{ $recinto->direccion }}</div>
                </div>
            </div>
            @endif

            <!-- Mesas del Recinto -->
            @if($recinto->mesas->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Mesas Electorales</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recinto->mesas as $mesa)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-800">Mesa {{ $mesa->numero }}</h3>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                {{ $mesa->jurados->count() }} jurados
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            <div class="mb-1">
                                <strong>Jurados:</strong>
                                @if($mesa->jurados->count() > 0)
                                    {{ $mesa->jurados->pluck('cargo')->join(', ') }}
                                @else
                                    Sin jurados asignados
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-table text-4xl mb-4"></i>
                <p>Este recinto no tiene mesas registradas.</p>
                <a href="{{ route('admin.ubicacion.mesas.create') }}" 
                   class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                    <i class="fas fa-plus mr-2"></i>Agregar primera mesa
                </a>
            </div>
            @endif

            <!-- Navegación rápida -->
            <div class="mt-8 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('admin.ubicacion.departamentos.index') }}" 
                   class="bg-gray-100 text-gray-800 p-4 rounded-lg text-center hover:bg-gray-200 transition-colors">
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
                   class="bg-blue-100 text-blue-800 p-4 rounded-lg text-center hover:bg-blue-200 transition-colors">
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
