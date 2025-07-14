<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Review Pesanan
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ringkasan Pesanan --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Pesanan</h3>

                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($cartItems as $item)
                        <li class="flex justify-between py-3">
                            <span class="text-gray-800 dark:text-gray-200">
                                {{ $item->product->name }} x {{ $item->quantity }}
                            </span>
                            <span class="text-gray-800 dark:text-gray-200">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4 flex justify-between font-bold text-gray-900 dark:text-white">
                    <span>Total:</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Informasi Pengiriman --}}
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Pengiriman</h3>
                <p><strong>Telepon:</strong> {{ $phone }}</p>
                <p><strong>Alamat:</strong> {{ $address }}</p>

                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    📦 <strong>Gratis Ongkir</strong> untuk wilayah <strong>Jabodetabek</strong>. Di luar wilayah tersebut, kami akan menghubungi Anda.
                </p>
            </div>

            {{-- Tombol Bayar via Midtrans --}}
            <div class="text-right">
                <button id="pay-button"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    Lanjut Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap --}}
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function (e) {
            e.preventDefault();

            fetch("{{ route('midtrans.token') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone: "{{ $phone }}",
                    address: "{{ $address }}"
                })
            })
            .then(response => response.json())
            .then(data => {
                snap.pay(data.token, {
                    onSuccess: function (result) {
                        alert("Pembayaran berhasil!");
                        console.log(result);
                        window.location.href = "{{ route('orders.index') }}";
                    },
                    onPending: function (result) {
                        alert("Menunggu pembayaran!");
                        console.log(result);
                        window.location.href = "{{ route('orders.index') }}";
                    },
                    onError: function (result) {
                        alert("Pembayaran gagal!");
                        console.log(result);
                    },
                    onClose: function () {
                        alert("Kamu menutup popup tanpa menyelesaikan pembayaran.");
                    }
                });
            })
            .catch(error => {
                alert("Terjadi kesalahan saat memproses pembayaran.");
                console.error(error);
            });
        });
    </script>
</x-app-layout>
