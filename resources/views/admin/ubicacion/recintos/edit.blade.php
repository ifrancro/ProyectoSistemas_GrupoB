@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Editar Recinto</h1>
                <a href="{{ route('admin.ubicacion.recintos.index') }}" 
                   class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <form method="POST" action="{{ route('admin.ubicacion.recintos.update', $recinto) }}">
                @csrf @method('PUT')
                
                <div class="mb-6">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre del Recinto *
                    </label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           value="{{ old('nombre', $recinto->nombre) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nombre') border-red-500 @enderror"
                           placeholder="Ej: Escuela Juan Pérez"
                           required>
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección
                    </label>
                    <input type="text" 
                           id="direccion" 
                           name="direccion" 
                           value="{{ old('direccion', $recinto->direccion) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('direccion') border-red-500 @enderror"
                           placeholder="Ej: Av. Heroínas #123">
                    @error('direccion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_asiento" class="block text-sm font-medium text-gray-700 mb-2">
                        Asiento *
                    </label>
                    <select id="id_asiento" 
                            name="id_asiento" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_asiento') border-red-500 @enderror"
                            required>
                        <option value="">Seleccionar Asiento</option>
                        @foreach($asientos as $asiento)
                            <option value="{{ $asiento->id_asiento }}" 
                                    {{ old('id_asiento', $recinto->id_asiento) == $asiento->id_asiento ? 'selected' : '' }}>
                                {{ $asiento->nombre }} - {{ $asiento->municipio->nombre }} - {{ $asiento->municipio->provincia->nombre }} - {{ $asiento->municipio->provincia->departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_asiento')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.ubicacion.recintos.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Actualizar Recinto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
