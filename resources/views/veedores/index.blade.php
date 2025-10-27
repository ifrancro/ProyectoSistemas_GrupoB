@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Consulta de Veedor</h2>
            <p class="text-gray-600">Ingrese su CI para consultar su estado</p>
        </div>

        <div class="bg-white py-8 px-6 shadow-lg rounded-lg">
            @if(session('mensaje'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('mensaje') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('veedores.consultar') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">
                        Cédula de Identidad
                    </label>
                    <input type="text" 
                           name="ci" 
                           id="ci"
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-lg"
                           placeholder="Ej: 1234567"
                           required>
                </div>

                <button type="submit" 
                        class="w-full bg-orange-600 text-white py-3 px-4 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-colors duration-200 font-semibold text-lg">
                    Consultar Estado
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-gray-500">
                    ¿No eres veedor? 
                    <a href="{{ route('voluntario.index') }}" class="text-orange-600 hover:text-orange-500 font-medium">
                        Volver al inicio
                    </a>
                </p>
                <p class="text-sm text-gray-500">
                    ¿Quieres ser veedor? 
                    <a href="{{ route('veedores.create') }}" class="text-orange-600 hover:text-orange-500 font-medium">
                        Registrarse aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
