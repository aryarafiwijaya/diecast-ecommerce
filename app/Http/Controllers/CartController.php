<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function review()
    {
        return redirect()->route('cart.index');
    }

    public function reviewPost(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kamu kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        return view('user.cart.review', [
            'cartItems' => $cartItems,
            'total'     => $total,
            'phone'     => $validated['phone'],
            'address'   => $validated['address'],
        ]);
    }

    public function getMidtransToken(Request $request)
    {
        $userId = Auth::id();

        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id'     => $userId,
            'total_price' => $total,
            'status'      => 'pending',
            'phone'       => $request->phone,
            'address'     => $request->address,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->price,
            ]);

            $item->product->decrement('stock', $item->quantity);
        }

        Cart::where('user_id', $userId)->delete();

        // Midtrans configuration
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id'     => 'ORDER-' . $order->id . '-' . time(),
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => $request->phone,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        // Checkout sudah dipindahkan ke getMidtransToken()
        return redirect()->route('orders.index')->with('success', 'Pembayaran sedang diproses.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantityToAdd = $request->input('quantity', 1);

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $currentQuantity = $cartItem?->quantity ?? 0;
        $newTotalQuantity = $currentQuantity + $quantityToAdd;

        if ($newTotalQuantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok.');
        }

        if ($cartItem) {
            $cartItem->increment('quantity', $quantityToAdd);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'quantity'   => $quantityToAdd,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan!');
    }

    public function destroy($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Keranjang dikosongkan.');
    }
}
