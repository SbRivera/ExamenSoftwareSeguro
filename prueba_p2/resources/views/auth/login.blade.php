<x-guest-layout>
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Iniciar Sesión</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm">Accede a tu cuenta</p>
    </div>

    {{-- Mensaje general de error --}}
    @if ($errors->has('email'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            {{ $errors->first('email') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                required
                autofocus
                autocomplete="username"
                value="{{ old('email') }}"
                class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-3 py-2"
            >
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="current-password"
                class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-200 px-3 py-2"
            >
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                >
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Recordarme</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">¿Olvidaste tu contraseña?</a>
            @endif
        </div>

        <!-- Submit -->
        <div>
            <button
                type="submit"
                class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md transition"
            >
                Iniciar Sesión
            </button>
        </div>
    </form>
</x-guest-layout>
