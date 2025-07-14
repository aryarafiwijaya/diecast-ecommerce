<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Informasi Umum --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Tanggal Pesan:</span>
                    <span class="text-gray-900 dark:text-white font-medium">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Status:</span>
                    <span class="px-2 py-1 text-sm rounded 
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'settlement') bg-green-100 text-green-700
                        @elseif($order->status === 'cancel') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-700 dark:text-gray-300">No. Telepon:</span>
                    <span class="text-gray-900 dark:text-white font-medium">{{ $order->phone }}</span>
                </div>

                <div class="flex flex-col sm:flex-row sm:justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Alamat Pengiriman:</span>
                    <span class="text-gray-900 dark:text-white font-medium sm:text-right sm:w-2/3">
                        {{ $order->address }}
                    </span>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Produk</h3>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                    @foreach ($order->items as $item)
                        <li class="py-2 flex justify-between">
                            <div>
                                {{ $item->product->name }} (x{{ $item->quantity }})
                            </div>
                            <div>
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 text-right font-bold text-gray-900 dark:text-white">
                    Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="text-right">
                <a href="{{ route('orders.index') }}"
                   class="text-blue-600 hover:underline text-sm">
                    &larr; Kembali ke Riwayat Pesanan
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
