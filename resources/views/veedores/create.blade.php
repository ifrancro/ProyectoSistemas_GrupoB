@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Registro de Veedor</h1>
            <p class="text-lg text-gray-600">Complete el formulario para solicitar ser veedor electoral</p>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-8">
            @if(session('mensaje'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('mensaje') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('veedores.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- CI -->
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">
                        Cédula de Identidad *
                    </label>
                    <input type="text" 
                           name="ci" 
                           id="ci"
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           placeholder="Ej: 1234567"
                           value="{{ old('ci') }}"
                           required>
                    @error('ci')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Institución -->
                <div>
                    <label for="institucion_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Institución *
                    </label>
                    <select name="institucion_id" 
                            id="institucion_id"
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            required>
                        <option value="">Seleccione una institución</option>
                        @foreach($instituciones as $institucion)
                            <option value="{{ $institucion->id_institucion }}" 
                                    {{ old('institucion_id') == $institucion->id_institucion ? 'selected' : '' }}>
                                {{ $institucion->nombre }} ({{ $institucion->sigla }})
                            </option>
                        @endforeach
                    </select>
                    @error('institucion_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Carta de Respaldo -->
                <div>
                    <label for="carta_respaldo" class="block text-sm font-medium text-gray-700 mb-2">
                        Carta de Respaldo *
                    </label>
                    <input type="file" 
                           name="carta_respaldo" 
                           id="carta_respaldo"
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Formatos permitidos: PDF, JPG, PNG (máximo 2MB)</p>
                    @error('carta_respaldo')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto de Carnet -->
                <div>
                    <label for="foto_carnet" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto de Carnet *
                    </label>
                    <input type="file" 
                           name="foto_carnet" 
                           id="foto_carnet"
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                           accept=".jpg,.jpeg,.png"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Formatos permitidos: JPG, PNG (máximo 2MB)</p>
                    @error('foto_carnet')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-blue-800">Información Importante</h3>
                            <ul class="text-sm text-blue-700 mt-1 space-y-1">
                                <li>• Su CI debe estar registrado en el sistema</li>
                                <li>• La carta de respaldo debe ser emitida por la institución seleccionada</li>
                                <li>• Su solicitud será revisada por el administrador</li>
                                <li>• Recibirá una notificación sobre el estado de su solicitud</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex space-x-4">
                    <button type="submit" 
                            class="flex-1 bg-orange-600 text-white py-3 px-4 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-semibold">
                        Enviar Solicitud
                    </button>
                    <a href="{{ route('voluntario.index') }}" 
                       class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 font-semibold text-center">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
