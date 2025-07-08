<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            👋 Bienvenido, {{ Auth::user()->name }}
        </h2>
    </x-slot>

    {{-- Contenido del dashboard --}}
    <div class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Mensaje introductorio --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-700">
                    Este panel te permite gestionar usuarios, roles, auditorías y más.
                    @if (Auth::user()->hasRole('admin'))
                        <span class="text-indigo-600 font-semibold">Como Administrador, tienes acceso completo.</span>
                    @else
                        <span class="text-green-600 font-semibold">Como Usuario, tienes acceso limitado.</span>
                    @endif
                </p>
            </div>

            {{-- Estadísticas rápidas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 text-indigo-600 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5.121 17.804A4.992 4.992 0 011 13V5a2 2 0 012-2h6.586a2 2 0 011.414.586l6.828 6.828a2 2 0 010 2.828l-6.828 6.828a2 2 0 01-2.828 0l-3.051-3.05z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Usuarios activos</p>
                        <p class="text-xl font-semibold text-gray-800">{{ \App\Models\User::where('is_active', true)->count() }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7 8h10M7 12h8m-8 4h6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Roles disponibles</p>
                        <p class="text-xl font-semibold text-gray-800">{{ \Spatie\Permission\Models\Role::count() }}</p>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 text-yellow-600 rounded-full p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 17v-2a4 4 0 014-4h3" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Registros de auditoría</p>
                        <p class="text-xl font-semibold text-gray-800">{{ \App\Models\AuditLog::count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Accesos rápidos --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Accesos rápidos</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @if (Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.users') }}" class="block px-4 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 text-center">
                        Gestionar Usuarios
                    </a>
                    <a href="{{ route('admin.audit-logs') }}" class="block px-4 py-3 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-center">
                        Ver Auditorías
                    </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-3 bg-gray-600 text-white rounded hover:bg-gray-700 text-center">
                        Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Script que revisa si el usuario sigue activo --}}
    <script>
        setInterval(() => {
            fetch('{{ route('check-active') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (!data.is_active) {
                    const encodedReason = encodeURIComponent(data.reason ?? 'Tu cuenta ha sido desactivada.');
                    window.location.href = '{{ route('force-logout') }}' + '?reason=' + encodedReason;
                }
            })
            .catch(err => {
                console.error(err);
                window.location.href = '{{ route('login') }}';
            });
        }, 10000);
    </script>
</x-app-layout>
