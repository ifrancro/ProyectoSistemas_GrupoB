<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sistema de Elecciones') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#004aad',
                        accent: '#007bff',
                        electoral: '#1e40af',
                        success: '#059669',
                        warning: '#d97706',
                        danger: '#dc2626'
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #004aad 0%, #007bff 100%);
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            transition: transform 0.2s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="gradient-bg text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo y título -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                            <span class="text-primary text-xl font-bold">🗳️</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold tracking-wide">Sistema de Elecciones</h1>
                            <p class="text-xs text-blue-200">Proyecto Univalle</p>
                        </div>
                    </a>
                </div>

                <!-- Navegación -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('academia.index') }}" 
                       class="hover:text-blue-200 transition-colors duration-200 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Academia</span>
                    </a>
                    <a href="{{ route('voluntario.index') }}" 
                       class="hover:text-blue-200 transition-colors duration-200 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Voluntarios</span>
                    </a>
                    <a href="{{ route('admin.login') }}" 
                       class="bg-white text-primary px-4 py-2 rounded-lg hover:bg-blue-50 transition-colors duration-200 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>Administrador</span>
                    </a>
                </div>

                <!-- Menú móvil -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-blue-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menú móvil desplegable -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('academia.index') }}" class="text-white hover:text-blue-200 py-2">Academia</a>
                    <a href="{{ route('voluntario.index') }}" class="text-white hover:text-blue-200 py-2">Voluntarios</a>
                    <a href="{{ route('admin.login') }}" class="bg-white text-primary px-4 py-2 rounded-lg hover:bg-blue-50">Administrador</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido dinámico -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Información del sistema -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Sistema de Elecciones</h3>
                    <p class="text-gray-300 text-sm">
                        Plataforma unificada para la gestión de jurados, veedores y delegados, 
                        con módulos de capacitación, credenciales y control electoral.
                    </p>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Acceso Rápido</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('academia.index') }}" class="text-gray-300 hover:text-white">Academia Electoral</a></li>
                        <li><a href="{{ route('voluntario.index') }}" class="text-gray-300 hover:text-white">Consulta de Voluntarios</a></li>
                        <li><a href="{{ route('admin.login') }}" class="text-gray-300 hover:text-white">Panel Administrativo</a></li>
                    </ul>
                </div>

                <!-- Información institucional -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Proyecto Univalle</h3>
                    <p class="text-gray-300 text-sm">
                        Sistema desarrollado como proyecto académico para la 
                        Universidad del Valle - Facultad de Ingeniería.
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center">
                <p class="text-gray-400 text-sm">
                    © {{ date('Y') }} Sistema de Elecciones – Proyecto Univalle. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>

    <!-- Script para menú móvil -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
