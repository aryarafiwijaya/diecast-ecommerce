<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ auth()->check() && auth()->user()->is_admin ? 'Dashboard Admin' : 'Beranda' }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-8">
                    @auth
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Selamat Datang di Beranda Onatman Diecast, {{ auth()->user()->name }}!
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Happy Shopping!
                        </p>
                    @endauth

                    @guest
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Selamat Datang di Onatman Diecast!
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Silakan <a href="{{ route('login') }}" class="text-blue-500 underline">Login</a> atau 
                            <a href="{{ route('register') }}" class="text-blue-500 underline">Daftar</a> untuk mulai berbelanja.
                        </p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
