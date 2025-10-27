@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Consulta de Voluntario</h2>
            <p class="text-gray-600">Ingrese su CI para consultar su rol electoral</p>
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

            <form method="POST" action="{{ route('vol.consultar') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">
                        Cédula de Identidad
                    </label>
                    <input type="text" 
                           name="ci" 
                           id="ci"
                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-lg"
                           placeholder="Ej: 1234567"
                           required>
                </div>

                <button type="submit" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 font-semibold text-lg">
                    Consultar Rol
                </button>
            </form>

            <div class="mt-6 text-center space-y-2">
                <p class="text-sm text-gray-500">
                    ¿Quieres capacitarte? 
                    <a href="{{ route('academia.index') }}" class="text-green-600 hover:text-green-500 font-medium">
                        Accede a la Academia Electoral
                    </a>
                </p>
                <p class="text-sm text-gray-500">
                    ¿Quieres ser veedor electoral? 
                    <a href="{{ route('vol.veedor.create') }}" class="text-green-600 hover:text-green-500 font-medium">
                        Regístrate como Veedor
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection