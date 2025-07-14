<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Ambil data JSON dari Midtrans
        $payload = $request->all();

        Log::info('📩 Midtrans Webhook Received', $payload);

        $orderId = $payload['order_id'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Cari order berdasarkan ID (contoh: ORDER-8)
        $order = Order::where('order_code', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update status order berdasarkan status transaksi dari Midtrans
        switch ($transactionStatus) {
            case 'capture':
            case 'settlement':
                $order->status = 'paid'; // Status sudah dibayar
                break;

            case 'pending':
                $order->status = 'pending'; // Menunggu pembayaran
                break;

            case 'deny':
            case 'cancel':
                $order->status = 'cancelled'; // Gagal/cancel
                break;

            case 'expire':
                $order->status = 'expired'; // Kadaluarsa
                break;

            default:
                $order->status = 'unknown';
                break;
        }

        $order->save();

        return response()->json(['message' => 'Webhook processed successfully']);
    }
}
