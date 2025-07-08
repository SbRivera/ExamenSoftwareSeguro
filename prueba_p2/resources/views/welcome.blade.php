<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Usuarios</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="max-w-3xl w-full bg-white dark:bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Header -->
        <header class="flex justify-between items-center bg-gradient-to-r from-blue-600 to-purple-600 dark:from-purple-800 dark:to-purple-900 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Gestión de Usuarios</h1>
            <nav class="space-x-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-block px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-medium transition">
                            Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-block px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-medium transition">
                            Iniciar sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-block px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-medium transition">
                                Registrarse
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

        <!-- Main Content -->
        <main class="p-6 md:p-10 space-y-6">
            <div class="flex items-center space-x-4">
                <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A4.992 4.992 0 011 13V5a2 2 0 012-2h6.586a2 2 0 011.414.586l6.828 6.828a2 2 0 010 2.828l-6.828 6.828a2 2 0 01-2.828 0l-3.051-3.05z" />
                </svg>
                <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">Bienvenido/a al Sistema</h2>
            </div>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                Esta plataforma te permite administrar usuarios, roles y permisos de manera sencilla y segura.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 dark:bg-gray-800 rounded-xl p-5 flex items-center space-x-4 shadow hover:shadow-md transition">
                    <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A4.992 4.992 0 011 13V5a2 2 0 012-2h6.586a2 2 0 011.414.586l6.828 6.828a2 2 0 010 2.828l-6.828 6.828a2 2 0 01-2.828 0l-3.051-3.05z" />
                    </svg>
                    <span class="text-gray-800 dark:text-gray-200 font-medium">Registrar nuevos usuarios</span>
                </div>
                <div class="bg-purple-50 dark:bg-gray-800 rounded-xl p-5 flex items-center space-x-4 shadow hover:shadow-md transition">
                    <svg class="w-6 h-6 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 8h10M7 12h8m-8 4h6M5 20h14a2 2 0 002-2V4a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="text-gray-800 dark:text-gray-200 font-medium">Gestionar roles y permisos</span>
                </div>
                <div class="bg-pink-50 dark:bg-gray-800 rounded-xl p-5 flex items-center space-x-4 shadow hover:shadow-md transition">
                    <svg class="w-6 h-6 text-pink-500 dark:text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-2a4 4 0 014-4h3m4 4v6a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v2" />
                    </svg>
                    <span class="text-gray-800 dark:text-gray-200 font-medium">Ver historial de actividad</span>
                </div>
                <div class="bg-green-50 dark:bg-gray-800 rounded-xl p-5 flex items-center space-x-4 shadow hover:shadow-md transition">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-gray-800 dark:text-gray-200 font-medium">Realizar auditorías</span>
                </div>
            </div>
            @auth
            <div class="mt-6">
                <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow">
                    Ir al Panel de Control
                </a>
            </div>
            @endauth
        </main>
    </div>
</body>
</html>
