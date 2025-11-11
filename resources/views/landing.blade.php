@extends('layouts.app')
@section('content')
<!-- Hero Section -->
<section class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <div class="mb-8">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-primary text-4xl font-bold">🗳️</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Sistema de Elecciones
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto text-blue-100">
                    Plataforma unificada para la gestión de jurados, veedores y delegados, 
                    con módulos de capacitación, credenciales y control electoral.
                </p>
            </div>

            <!-- Botones principales -->
            <div class="flex flex-wrap justify-center gap-6 mb-12">
                <a href="{{ route('admin.login') }}" 
                   class="bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-blue-50 shadow-lg hover-lift transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Entrar como Administrador</span>
                </a>
                <a href="{{ route('voluntario.index') }}" 
                   class="bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-blue-50 shadow-lg hover-lift transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>Ingresar como Voluntario</span>
                </a>
                <a href="{{ route('academia.index') }}" 
                   class="bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-blue-50 shadow-lg hover-lift transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span>Academia Electoral</span>
                </a>
                <a href="http://127.0.0.1:8001" 
                   class="bg-white text-primary font-semibold px-8 py-4 rounded-lg hover:bg-blue-50 shadow-lg hover-lift transition-all duration-200 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h6m0 0v6m0-6l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Ir a Proyecto de Votaciones</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Características del sistema -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Características del Sistema</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Una solución completa para la gestión electoral moderna
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Gestión de Roles -->
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Gestión de Roles</h3>
                <p class="text-gray-600">Sorteo automático de jurados, validación de veedores y asignación de delegados</p>
            </div>

            <!-- Credenciales Digitales -->
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Credenciales Digitales</h3>
                <p class="text-gray-600">Generación automática de credenciales con códigos QR para identificación</p>
            </div>

            <!-- Academia Virtual -->
            <div class="text-center p-6">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Academia Virtual</h3>
                <p class="text-gray-600">Materiales de capacitación específicos para cada rol electoral</p>
            </div>
        </div>
    </div>
</section>

<!-- Información institucional -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Proyecto Univalle</h2>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto mb-8">
                Sistema desarrollado como proyecto académico para la Universidad del Valle - 
                Facultad de Ingeniería, demostrando las mejores prácticas en desarrollo web moderno.
            </p>
            <div class="flex justify-center">
                <div class="bg-white rounded-lg p-6 card-shadow">
                    <p class="text-sm text-gray-500">
                        <strong>Tecnologías:</strong> Laravel, PHP, MySQL, Tailwind CSS, JavaScript
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
