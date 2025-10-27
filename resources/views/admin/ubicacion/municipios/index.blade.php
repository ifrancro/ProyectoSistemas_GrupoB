@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de Municipios</h1>
        <a href="{{ route('admin.ubicacion.municipios.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i>Nuevo Municipio
        </a>
    </div>

    @if(session('ok'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('ok') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Provincia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asientos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($municipios as $municipio)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $municipio->id_municipio }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $municipio->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $municipio->provincia->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $municipio->provincia->departamento->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                            {{ $municipio->asientos->count() }} asientos
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.ubicacion.municipios.show', $municipio) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="{{ route('admin.ubicacion.municipios.edit', $municipio) }}" 
                               class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.ubicacion.municipios.destroy', $municipio) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('¿Estás seguro de eliminar este municipio?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No hay municipios registrados.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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
           class="bg-blue-100 text-blue-800 p-4 rounded-lg text-center hover:bg-blue-200 transition-colors">
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
@endsection
