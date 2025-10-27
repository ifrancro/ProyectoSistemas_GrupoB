@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-eye text-green-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Registro de Veedor</h1>
            <p class="text-gray-600">Complete el formulario para solicitar ser veedor electoral</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('mensaje'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check mr-2"></i>
                    {{ session('mensaje') }}
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form method="POST" action="{{ route('vol.veedor.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Campo CI con búsqueda automática -->
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">
                        Cédula de Identidad <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="ci" 
                           id="ci"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           placeholder="Ej: 1234567"
                           required
                           onblur="buscarPersona()">
                    <p class="mt-1 text-sm text-gray-500">Ingrese su CI para autocompletar los datos</p>
                </div>

                <!-- Información autocompletada -->
                <div id="info-persona" class="hidden bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Información Personal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <p id="nombre" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellido</label>
                            <p id="apellido" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <p id="ciudad" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                            <p id="fecha_nacimiento" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <p id="estado" class="mt-1 text-sm text-gray-900"></p>
                        </div>
                    </div>
                </div>

                <!-- Selección de Institución -->
                <div>
                    <label for="institucion_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Institución <span class="text-red-500">*</span>
                    </label>
                    <select name="institucion_id" 
                            id="institucion_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required>
                        <option value="">Seleccione una institución</option>
                        @foreach($instituciones as $institucion)
                            <option value="{{ $institucion->id_institucion }}">{{ $institucion->nombre }} ({{ $institucion->sigla }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Carta de Respaldo -->
                <div>
                    <label for="carta_respaldo" class="block text-sm font-medium text-gray-700 mb-2">
                        Carta de Respaldo <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="carta_respaldo" 
                           id="carta_respaldo"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           accept=".pdf,.jpg,.jpeg,.png"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Formatos permitidos: PDF, JPG, JPEG, PNG (máximo 2MB)</p>
                </div>

                <!-- Foto de Carnet -->
                <div>
                    <label for="foto_carnet" class="block text-sm font-medium text-gray-700 mb-2">
                        Foto de Carnet <span class="text-red-500">*</span>
                    </label>
                    <input type="file" 
                           name="foto_carnet" 
                           id="foto_carnet"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           accept=".jpg,.jpeg,.png"
                           required>
                    <p class="mt-1 text-sm text-gray-500">Formatos permitidos: JPG, JPEG, PNG (máximo 2MB)</p>
                </div>

                <!-- Botones -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Solicitud
                    </button>
                    
                    <a href="{{ route('voluntario.index') }}" 
                       class="flex-1 bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200 font-semibold text-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function buscarPersona() {
    const ci = document.getElementById('ci').value;
    if (ci.length < 5) return;

    fetch(`/voluntario/buscar-persona?ci=${ci}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('info-persona').classList.add('hidden');
                return;
            }

            document.getElementById('nombre').textContent = data.nombre;
            document.getElementById('apellido').textContent = data.apellido;
            document.getElementById('ciudad').textContent = data.ciudad || 'N/A';
            document.getElementById('fecha_nacimiento').textContent = data.fecha_nacimiento || 'N/A';
            document.getElementById('estado').textContent = data.estado || 'N/A';
            
            document.getElementById('info-persona').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('info-persona').classList.add('hidden');
        });
}
</script>
@endsection
