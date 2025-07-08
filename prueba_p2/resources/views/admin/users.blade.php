<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            👥 Administrar Usuarios
        </h2>
    </x-slot>

    <div
        x-data="{ showModal: {{ session('show_modal') || $errors->any() ? 'true' : 'false' }} }"
        x-init="
            if(showModal){document.body.classList.add('overflow-hidden')}
            $watch('showModal', value => {
                if(value){
                    document.body.classList.add('overflow-hidden')
                } else {
                    document.body.classList.remove('overflow-hidden')
                }
            })
        "
        @keydown.escape.window="showModal=false"
    >
        {{-- Filtros --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Busqueda --}}
            <form method="GET" action="{{ route('admin.users') }}" class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <input
                    type="text"
                    name="search"
                    placeholder="Buscar por nombre o email..."
                    value="{{ request('search') }}"
                    class="w-full md:w-1/3 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
                <input
                    type="number"
                    name="per_page"
                    min="1"
                    placeholder="Registros por página"
                    value="{{ request('per_page', 10) }}"
                    class="w-full md:w-48 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Aplicar
                </button>
            </form>

            @if(session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('status') }}
            </div>
            @endif

            {{-- Tabla --}}
            <div class="overflow-x-auto bg-white shadow rounded">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @if ($user->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">
                                    Activo
                                </span>
                                @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">
                                    Inactivo
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <form
                                    method="POST"
                                    action="{{ route('admin.users.update', $user) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button
                                        type="submit"
                                        name="open_modal"
                                        value="1"
                                        class="px-3 py-1 rounded text-white {{ $user->is_active ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No se encontraron usuarios.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>

        {{-- Modal --}}
        @if(session('show_modal') || $errors->any())
        <div
            x-show="showModal"
            x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60">
            <div @click.away="showModal=false" class="bg-white w-full max-w-lg p-6 rounded-lg shadow-2xl space-y-4">
                <h3 class="text-xl font-semibold text-gray-800">Confirmar cambio de estado del usuario</h3>
                <p class="text-sm text-gray-600">Por favor indica el motivo y confirma con tu contraseña.</p>
                <form method="POST" action="{{ route('admin.users.update', old('user_id')) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="is_active" value="{{ old('is_active') }}">
                    <input type="hidden" name="user_id" value="{{ old('user_id') }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Motivo del cambio</label>
                        <textarea
                            name="reason"
                            class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300"
                            rows="3">{{ old('reason') }}</textarea>
                        @error('reason')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contraseña de administrador</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Escribe tu contraseña"
                            class="w-full mt-1 border rounded px-3 py-2 focus:outline-none focus:ring focus:border-indigo-300">
                        @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-2">
                        <button
                            type="button"
                            @click="showModal=false"
                            class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-50">Cancelar</button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
