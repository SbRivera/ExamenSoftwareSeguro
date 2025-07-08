<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800">
            📝 Registro de Auditoría
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Filtros --}}
        <form method="GET" class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
            <input
                type="text"
                name="search"
                placeholder="Buscar por usuario, admin o acción..."
                value="{{ request('search') }}"
                class="w-full md:w-1/3 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
            <input
                type="number"
                name="per_page"
                min="1"
                placeholder="Registros por página"
                value="{{ request('per_page', 20) }}"
                class="w-full md:w-48 px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Aplicar
            </button>
        </form>

        {{-- Tabla --}}
        <div class="overflow-x-auto bg-white shadow rounded">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario afectado</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Administrador</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acción</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                    <tr>
                        <td class="px-4 py-3">{{ $log->id }}</td>
                        <td class="px-4 py-3">{{ $log->user ? $log->user->email : 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $log->admin ? $log->admin->email : 'N/A' }}</td>
                        <td class="px-4 py-3 capitalize">
                            @if($log->action === 'activate')
                                <span class="text-green-700 font-semibold">Activado</span>
                            @elseif($log->action === 'deactivate')
                                <span class="text-red-700 font-semibold">Desactivado</span>
                            @else
                                {{ ucfirst($log->action) }}
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $log->details['reason'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                            No se encontraron registros de auditoría.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
