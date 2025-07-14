@extends('layouts.admin')

@section('content')
    <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Daftar Pesanan</h2>

        @if ($orders->isEmpty())
            <p class="text-gray-600 dark:text-gray-300">Belum ada pesanan yang masuk.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                            <th class="px-6 py-3 text-left">ID</th>
                            <th class="px-6 py-3 text-left">User</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900 dark:text-white">
                        @foreach ($orders as $order)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $order->id }}</td>
                                <td class="px-6 py-4">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 capitalize">{{ $order->status }}</td>
                                <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                       class="text-blue-600 hover:underline text-sm">Lihat</a>

                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
