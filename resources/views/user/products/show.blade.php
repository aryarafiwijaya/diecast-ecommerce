<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Produk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover mb-4 rounded">

                    <p class="mb-2">Harga: 
                        <span class="font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </p>

                    {{-- ✅ Menampilkan sisa stok --}}
                    <p class="mb-2 text-sm text-gray-300">
                        <strong>Stok Tersedia:</strong> {{ $product->stock }} item
                    </p>

                    <p class="mb-4">{{ $product->description }}</p>

                    {{-- ✅ Form Tambah ke Keranjang --}}
                    @if ($product->stock > 0)
                        <form action="{{ route('cart.store') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="flex items-center space-x-2">
                                <input 
                                    type="number" 
                                    name="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="{{ $product->stock }}" 
                                    class="w-16 px-2 py-1 rounded border dark:bg-gray-800 dark:border-gray-700"
                                >
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4 text-red-500 font-semibold">
                            Produk ini sedang habis stok.
                        </div>
                        <button 
                            class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed" 
                            disabled>
                            Tambah ke Keranjang
                        </button>
                    @endif

                    <a href="{{ route('shop.index') }}" 
                       class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded mt-4">
                        ← Kembali ke Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
