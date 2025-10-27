@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gestión de Jurados</h1>
                    <p class="mt-2 text-sm text-gray-600">Administra el sorteo y verificación de jurados electorales</p>
                </div>
                <div class="flex space-x-2">
                    <form action="{{ route('admin.jurados.sorteo') }}" method="POST" class="inline">
                        @csrf
                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors" 
                                onclick="return confirm('¿Realizar sorteo de jurados? Esto asignará personas a las mesas.')">
                            <i class="fas fa-random mr-2"></i>Realizar Sorteo
                        </button>
                    </form>
                    <form action="{{ route('admin.jurados.eliminar') }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors"
                                onclick="return confirm('¿Eliminar todo el sorteo? Esto borrará todas las asignaciones de jurados.')">
                            <i class="fas fa-trash mr-2"></i>Eliminar Sorteo
                        </button>
                    </form>
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
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Jurados Asignados ({{ $jurados->count() }} total)</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mesa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recinto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($jurados as $jurado)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Mesa {{ $jurado->mesa->numero }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $jurado->mesa->recinto->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $jurado->mesa->recinto->asiento->municipio->nombre }}, {{ $jurado->mesa->recinto->asiento->municipio->provincia->nombre }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $jurado->persona->ci }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $jurado->persona->nombre }} {{ $jurado->persona->apellido }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($jurado->cargo == 'PRESIDENTE')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-crown mr-1"></i>PRESIDENTE
                                </span>
                            @elseif($jurado->cargo == 'SECRETARIO')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-pen mr-1"></i>SECRETARIO
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-user mr-1"></i>VOCAL
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($jurado->verificado)
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-check mr-1"></i>VERIFICADO
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-clock mr-1"></i>PENDIENTE
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.jurados.verificar', $jurado) }}" method="POST" class="inline">
                                @csrf @method('PATCH')
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition-colors"
                                        onclick="return confirm('¿{{ $jurado->verificado ? 'Desmarcar' : 'Marcar como verificado' }} este jurado?')">
                                    <i class="fas fa-{{ $jurado->verificado ? 'times' : 'check' }} mr-1"></i>
                                    {{ $jurado->verificado ? 'Desmarcar' : 'Verificar' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No hay jurados asignados. Realice un sorteo para comenzar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Estadísticas -->
    @if($jurados->count() > 0)
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Presidentes</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $jurados->where('cargo', 'PRESIDENTE')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-pen text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Secretarios</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $jurados->where('cargo', 'SECRETARIO')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Vocales</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $jurados->where('cargo', 'VOCAL')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-gray-600 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Verificados</h3>
                    <p class="text-3xl font-bold text-gray-600">{{ $jurados->where('verificado', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif
    </div>
</div>
@endsection
