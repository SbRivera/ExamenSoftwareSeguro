<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center text-indigo-600 font-bold text-lg">
                    🔐 Gestión de Usuarios
                </a>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ route('dashboard') }}"
                       class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                        Inicio
                    </a>
                    @role('admin')
                        <a href="{{ route('admin.users') }}"
                           class="text-sm font-medium {{ request()->routeIs('admin.users') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                            Usuarios
                        </a>
                        <a href="{{ route('admin.audit-logs') }}"
                           class="text-sm font-medium {{ request()->routeIs('admin.audit-logs') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-600 hover:text-indigo-600' }}">
                            Auditorías
                        </a>
                    @endrole
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-800">
                    {{ Auth::user()->name }}
                    @if(Auth::user()->hasRole('admin'))
                        <span class="text-yellow-600">(Administrador)</span>
                    @else
                        <span class="text-green-600">(Usuario)</span>
                    @endif
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>
