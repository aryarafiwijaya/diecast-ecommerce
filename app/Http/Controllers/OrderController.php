<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate; 

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan hanya pemilik yang bisa lihat pesanan ini
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.product'); // eager load relasi

        return view('user.orders.show', compact('order'));
    }
}
