<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard'));
    }
}; 
?>

<div class="flex flex-col justify-center items-center min-h-screen bg-gray-900 text-white">

    {{-- Logo --}}
    <div class="mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-32 h-32">
    </div>

    {{-- Form --}}
    <div class="w-full max-w-md bg-gray-800 p-6 rounded-lg shadow-lg">

        <form wire:submit.prevent="register">
            {{-- Nama --}}
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" placeholder="Masukkan nama lengkap" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" placeholder="nama@email.com" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="__('Kata Sandi')" />
                <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Minimal 8 karakter" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Aksi --}}
            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-400 hover:underline" href="{{ route('login') }}" wire:navigate>
                    Sudah punya akun?
                </a>

                <x-primary-button>
                    {{ __('Daftar') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</div>
