<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();

        // Filter kategori jika dipilih
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter pencarian nama produk
        if ($request->filled('search')) {
            $query->where('name', 'ILIKE', '%' . $request->search . '%'); // PostgreSQL (case-insensitive)
        }

        $products = $query->latest()->paginate(8);

        return view('user.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        return view('user.products.show', compact('product'));
    }
}
