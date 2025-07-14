<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Produk Tersedia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Form Pencarian dan Filter --}}
            <form method="GET" action="{{ route('shop.index') }}" class="mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-3 md:space-y-0">

                    {{-- Input Pencarian --}}
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama produk..."
                        class="w-full md:w-1/3 px-3 py-2 rounded border dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    >

                    {{-- Dropdown Kategori --}}
                    <select
                        name="category"
                        onchange="this.form.submit()"
                        class="px-3 py-2 rounded border dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Tombol Reset Filter (jika ada kategori dipilih) --}}
                    @if (request('category') || request('search'))
                        <a href="{{ route('shop.index') }}"
                           class="text-sm text-red-600 dark:text-red-400 hover:underline">
                            Reset
                        </a>
                    @endif

                    {{-- Tombol Submit (untuk pencarian manual di mobile) --}}
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Daftar Produk --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($products as $product)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow hover:shadow-lg transition">
                        <img 
                            src="{{ asset('storage/' . $product->image) }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-40 object-cover rounded mb-2"
                        >

                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $product->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            <strong>Stok:</strong> {{ $product->stock > 0 ? $product->stock . ' item' : 'Habis' }}
                        </p>

                        <a href="{{ route('shop.show', $product->id) }}" 
                           class="inline-block text-sm text-blue-500 hover:underline mb-2">
                            Lihat Detail
                        </a>

                        @if ($product->stock > 0)
                            <form method="POST" action="{{ route('cart.store') }}" class="mt-2">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button 
                                    type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mt-1 transition">
                                    + Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <button 
                                class="w-full bg-gray-400 text-white px-4 py-2 rounded mt-1 cursor-not-allowed" 
                                disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                @empty
                    <p class="col-span-3 text-gray-600 dark:text-gray-300">
                        Tidak ada produk ditemukan.
                    </p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
