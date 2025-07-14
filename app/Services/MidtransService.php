<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public static function getSnapToken($order)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(), // pastikan unik
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->phone,
            ]
        ];

        // Dapatkan Snap Token dari Midtrans
        return Snap::getSnapToken($params);
    }
}
