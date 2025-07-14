<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil hanya kolom penting & relasi user dengan kolom minimal
        $orders = Order::with(['user:id,name']) // hanya ambil nama user
            ->select('id', 'user_id', 'total_price', 'status', 'created_at')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        // Ambil detail order + produk terkait + user lengkap
        $order = Order::with([
            'user:id,name,email',
            'items.product:id,name'
        ])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Hapus item-item terkait terlebih dahulu
        $order->items()->delete();

        // Hapus order-nya
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
