<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        Payment::create([
            'order_id' => 1, // pastikan order_id 1 ada
            'payment_method' => 'Transfer Bank',
            'payment_proof' => 'bukti_transfer.jpg' // bisa kosong dulu
        ]);
    }
}
