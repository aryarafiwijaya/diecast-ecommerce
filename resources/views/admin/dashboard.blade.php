<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('Dashboard Admin Onatman') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-8">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Selamat Datang Admin Pengelola Onatman!
                    </h3>

                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        Gunakan dashboard ini untuk mengelola produk, pesanan, dan lainnya.
                        Selamat Bekerja!
                    </p>

                    <a href="{{ route('admin.products.index') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition">
                        Kelola Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
