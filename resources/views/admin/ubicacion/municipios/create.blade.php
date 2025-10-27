@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Nuevo Municipio</h1>
                <a href="{{ route('admin.ubicacion.municipios.index') }}" 
                   class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <form method="POST" action="{{ route('admin.ubicacion.municipios.store') }}">
                @csrf
                
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Municipio *
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: Cochabamba"
                           required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_provincia" class="block text-sm font-medium text-gray-700 mb-2">
                        Provincia *
                    </label>
                    <select id="id_provincia" 
                            name="id_provincia" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_provincia') border-red-500 @enderror"
                            required>
                        <option value="">Seleccionar Provincia</option>
                        @foreach($provincias as $provincia)
                            <option value="{{ $provincia->id_provincia }}" 
                                    {{ old('id_provincia') == $provincia->id_provincia ? 'selected' : '' }}>
                                {{ $provincia->nombre }} - {{ $provincia->departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_provincia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.ubicacion.municipios.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Guardar Municipio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
