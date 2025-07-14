<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-64 h-64 object-cover mb-4 rounded" alt="Gambar Produk">
                @endif

                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ $product->name }}</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-2">{{ $product->description }}</p>
                <p class="text-gray-900 dark:text-gray-100 font-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-gray-600 dark:text-gray-400">Stok: {{ $product->stock }}</p>

                <a href="{{ route('admin.products.index') }}" class="mt-4 inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
