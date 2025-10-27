@extends('layouts.app')
@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Nueva Mesa</h1>
                <a href="{{ route('admin.ubicacion.mesas.index') }}" 
                   class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <form method="POST" action="{{ route('admin.ubicacion.mesas.store') }}">
                @csrf
                
                <div class="mb-6">
                    <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">
                        Número de Mesa *
                    </label>
                    <input type="number" 
                           id="numero" 
                           name="numero" 
                           value="{{ old('numero') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('numero') border-red-500 @enderror"
                           placeholder="Ej: 1"
                           min="1"
                           required>
                    @error('numero')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="id_recinto" class="block text-sm font-medium text-gray-700 mb-2">
                        Recinto *
                    </label>
                    <select id="id_recinto" 
                            name="id_recinto" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('id_recinto') border-red-500 @enderror"
                            required>
                        <option value="">Seleccionar Recinto</option>
                        @foreach($recintos as $recinto)
                            <option value="{{ $recinto->id_recinto }}" 
                                    {{ old('id_recinto') == $recinto->id_recinto ? 'selected' : '' }}>
                                {{ $recinto->nombre }} - {{ $recinto->asiento->municipio->nombre }} - {{ $recinto->asiento->municipio->provincia->nombre }} - {{ $recinto->asiento->municipio->provincia->departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_recinto')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.ubicacion.mesas.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Guardar Mesa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
