<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Riwayat Pesanan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($orders->isEmpty())
                <p class="text-gray-600 dark:text-gray-300">Kamu belum memiliki pesanan.</p>
            @else
                <div class="space-y-6">
                    @foreach ($orders as $order)
                        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    Pesanan #{{ $order->id }}
                                </h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    Status: <strong>{{ ucfirst($order->status) }}</strong>
                                </span>
                            </div>

                            <ul class="text-sm text-gray-700 dark:text-gray-300 mb-3">
                                @foreach ($order->items as $item)
                                    <li>
                                        {{ $item->product->name }} &times; {{ $item->quantity }} - 
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>

                            <div class="font-bold text-gray-900 dark:text-white">
                                Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </div>

                            <div class="mt-3 text-right">
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                                    Detail Pesanan
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
