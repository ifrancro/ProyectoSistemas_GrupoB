@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Veedores</h1>
                    <p class="mt-2 text-sm text-gray-600">Administra las solicitudes de veedores electorales</p>
                </div>
                <div class="text-sm text-gray-600">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                        {{ $veedores->count() }} solicitudes
                    </span>
                </div>
            </div>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institución</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($veedores as $veedor)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $veedor->id_veedor }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $veedor->persona->ci }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $veedor->persona->nombre }} {{ $veedor->persona->apellido }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $veedor->institucion->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($veedor->estado == 'PENDIENTE')
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                PENDIENTE
                            </span>
                        @elseif($veedor->estado == 'APROBADO')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                APROBADO
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                                RECHAZADO
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        @if($veedor->estado == 'PENDIENTE')
                            <div class="flex space-x-2">
                                <form action="{{ route('admin.veedores.aprobar', $veedor) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition-colors"
                                            onclick="return confirm('¿Aprobar esta solicitud de veedor?')">
                                        <i class="fas fa-check mr-1"></i>Aprobar
                                    </button>
                                </form>
                                <button onclick="toggleRechazo({{ $veedor->id_veedor }})" 
                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition-colors">
                                    <i class="fas fa-times mr-1"></i>Rechazar
                                </button>
                            </div>
                            
                            <!-- Formulario de rechazo oculto -->
                            <div id="rechazo-{{ $veedor->id_veedor }}" class="hidden mt-2 p-3 bg-red-50 rounded-lg">
                                <form action="{{ route('admin.veedores.rechazar', $veedor) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="block text-sm font-medium text-red-800 mb-1">Motivo del rechazo:</label>
                                        <textarea name="motivo_rechazo" 
                                                  class="w-full px-3 py-2 border border-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                                  rows="2" 
                                                  placeholder="Explique el motivo del rechazo..."
                                                  required></textarea>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="submit" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition-colors">
                                            <i class="fas fa-times mr-1"></i>Confirmar Rechazo
                                        </button>
                                        <button type="button" 
                                                onclick="toggleRechazo({{ $veedor->id_veedor }})"
                                                class="bg-gray-600 text-white px-3 py-1 rounded text-xs hover:bg-gray-700 transition-colors">
                                            <i class="fas fa-times mr-1"></i>Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="text-sm text-gray-500">
                                @if($veedor->motivo_rechazo)
                                    <div class="max-w-xs">
                                        <span class="font-medium">Motivo:</span>
                                        <p class="text-xs mt-1">{{ $veedor->motivo_rechazo }}</p>
                                    </div>
                                @else
                                    <span class="text-green-600">Solicitud aprobada</span>
                                @endif
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No hay solicitudes de veedores registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</div>

<script>
function toggleRechazo(id) {
    const element = document.getElementById('rechazo-' + id);
    element.classList.toggle('hidden');
}
</script>
@endsection
