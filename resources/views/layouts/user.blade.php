{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white min-h-screen">

    <nav class="bg-white dark:bg-gray-800 shadow mb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <a href="{{ route('shop.index') }}" class="text-xl font-bold">
                E-Commerce
            </a>

            <div>
                <a href="{{ route('cart.index') }}" class="text-sm mx-2">🛒 Keranjang</a>
                <a href="{{ route('orders.index') }}" class="text-sm mx-2">📦 Pesanan</a>
                <a href="{{ route('dashboard') }}" class="text-sm mx-2">🏠 Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm mx-2">🚪 Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="px-4">
        @yield('content')
    </main>

</body>
</html>
