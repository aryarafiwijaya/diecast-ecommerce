<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'AdminOnatman',
            'email' => 'onatmandiecast@gmail.com',
            'password' => Hash::make('mcqueen17425'), 
            'email_verified_at' => now(),
            'role' => 'admin' 
        ]);
    }
}
