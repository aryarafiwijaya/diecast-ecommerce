<!-- resources/views/components/app-layout.blade.php -->
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    
    <!-- Header Section -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Main Content -->
    <main class="py-6">
        {{ $slot }}
    </main>

</div>
