<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;

class MidtransController extends Controller
{
    public function token(Request $request)
    {
        $orderId = $request->input('order_id');

        // Ambil data pesanan berdasarkan ID
        $order = Order::with('items.product')->findOrFail($orderId);

        // Set konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Data transaksi
        $params = [
            'transaction_details' => [
                'order_id'     => $order->id . '-' . time(), 
                'gross_amount' => $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->user->name,
                'phone'      => $order->phone,
                'address'    => $order->address,
            ],
            'item_details' => $order->items->map(function ($item) {
                return [
                    'id'       => $item->product_id,
                    'price'    => $item->price,
                    'quantity' => $item->quantity,
                    'name'     => $item->product->name,
                ];
            })->toArray(),
        ];

        // Buat Snap Token
        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
