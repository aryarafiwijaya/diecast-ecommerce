<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Keranjang Belanja
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($cartItems->isEmpty())
                <p class="text-gray-600 dark:text-gray-300">Keranjang kamu masih kosong.</p>
            @else
                {{-- Tombol Kosongkan Keranjang --}}
                <form action="{{ route('cart.clear') }}" method="POST" class="mb-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold">
                        Kosongkan Keranjang
                    </button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800 shadow rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                                <th class="px-6 py-3 text-left">Produk</th>
                                <th class="px-6 py-3 text-left">Harga</th>
                                <th class="px-6 py-3 text-left">Jumlah</th>
                                <th class="px-6 py-3 text-left">Subtotal</th>
                                <th class="px-6 py-3 text-left">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $item)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4">
                                            <img src="{{ asset('storage/' . $item->product->image) }}"
                                                class="w-20 h-20 rounded object-cover mx-auto sm:mx-0 mb-2 sm:mb-0"
                                                alt="{{ $item->product->name }}">
                                            <span class="text-center sm:text-left font-medium text-gray-900 dark:text-white">
                                                {{ $item->product->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center text-gray-800 dark:text-white font-semibold">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus produk ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right font-bold px-6 py-4 text-gray-900 dark:text-white">
                                    Total:
                                </td>
                                <td colspan="2" class="font-bold px-6 py-4 text-gray-900 dark:text-white">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- Form Input Pengiriman dan Checkout --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                            Informasi Pengiriman
                        </h3>

                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                            📦 <strong>Gratis Ongkir</strong> untuk wilayah <strong>Jabodetabek</strong>.
                            Di luar wilayah tersebut, kami akan menghubungi Anda melalui nomor telepon yang Anda berikan.
                        </p>

                        <form action="{{ route('cart.review') }}" method="POST" class="space-y-4">
                            @csrf

                            {{-- Nomor Telepon --}}
                            <div>
                                <label for="phone"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor Telepon (WA)
                                </label>
                                <input type="text" name="phone" id="phone" required
                                       value="{{ old('phone') }}"
                                       class="w-full mt-1 px-4 py-2 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            {{-- Alamat Pengiriman --}}
                            <div>
                                <label for="address"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Penerima dan Alamat Pengiriman
                                </label>
                                <textarea name="address" id="address" rows="3" required
                                          class="w-full mt-1 px-4 py-2 rounded border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                          placeholder="Tulis alamat lengkap kamu...">{{ old('address') }}</textarea>
                            </div>

                            {{-- Tombol Checkout --}}
                            <div class="text-right">
                                <button type="submit"
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                                    Checkout Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
