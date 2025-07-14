<x-guest-layout>
    <div class="flex flex-col justify-center items-center min-h-screen bg-gray-900">
        
        {{-- Logo --}}
        <div class="mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32">
        </div>

        {{-- Form Container --}}
        <div class="w-full max-w-md bg-gray-800 p-6 rounded-lg shadow-lg">

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Tombol Login --}}
                <div class="flex justify-end mt-6">
                    <x-primary-button>
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- Link Register --}}
            <p class="mt-6 text-center text-sm text-gray-400">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-400 hover:underline">
                    Daftar di sini
                </a>
            </p>

        </div>
    </div>
</x-guest-layout>
