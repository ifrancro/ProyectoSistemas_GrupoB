@extends('layouts.app')
@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-center">Academia Electoral</h1>
        
        <div class="bg-blue-100 p-4 rounded-lg mb-6">
            <h2 class="text-xl font-semibold mb-2">Bienvenido/a, {{ $persona->nombre }} {{ $persona->apellido_paterno }}</h2>
            <p class="text-gray-700">Rol: <span class="font-bold text-blue-800">{{ $rol }}</span></p>
            <p class="text-sm text-gray-600">CI: {{ $persona->ci }}</p>
        </div>

        <h3 class="text-2xl font-semibold mb-4">Materiales de Capacitación</h3>
        
        @if($capacitaciones->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($capacitaciones as $c)
                    <div class="border rounded-lg p-6 shadow hover:shadow-lg transition-shadow">
                        <h4 class="text-lg font-semibold mb-3 text-blue-800">{{ $c->titulo }}</h4>
                        @if($c->descripcion)
                            <p class="text-gray-700 mb-4">{{ $c->descripcion }}</p>
                        @endif
                        @if($c->link_material)
                            <a href="{{ $c->link_material }}" target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                Ver Material
                            </a>
                        @else
                            <span class="text-gray-500 text-sm">Material no disponible</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-gray-500 text-lg mb-4">No hay materiales de capacitación disponibles para tu rol</div>
                <a href="{{ route('academia.index') }}" class="text-blue-600 hover:underline">Volver al inicio</a>
            </div>
        @endif

        <div class="mt-8 text-center">
            <a href="{{ route('academia.index') }}" class="text-blue-600 hover:underline">← Volver al inicio</a>
        </div>
    </div>
</div>
@endsection
