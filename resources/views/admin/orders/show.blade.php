<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            Detail Pesanan #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Informasi User --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Informasi Pelanggan</h3>
                <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                <p><strong>Email:</strong> {{ $order->user->email }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $order->phone ?? '-' }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $order->address ?? '-' }}</p>
            </div>

            {{-- Informasi Pesanan --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Detail Pesanan</h3>
                <p><strong>ID Pesanan:</strong> {{ $order->id }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
                <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>

            {{-- Daftar Produk --}}
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Produk dalam Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Nama Produk</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Kuantitas</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Harga Satuan</th>
                                <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->product->name }}</td>
                                    <td class="px-4 py-2">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Kembali --}}
            <div class="text-right">
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:underline">← Kembali ke daftar pesanan</a>
            </div>
        </div>
    </div>
</x-app-layout>
