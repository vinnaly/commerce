<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // ✅ Halaman semua produk dengan filter kategori & harga
    public function collection(Request $request)
    {
        $query = Product::with('category')
            ->where('stock', '>', 0); // Hanya produk dengan stok > 0

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        $products = $query->latest()->get();
        $categories = Category::withCount('products')->get();

        return view('frontend.product.collection', compact('products', 'categories'));
    }


    // ✅ Detail Produk
    public function detail($slug)
    {
        $product = Product::where('slug', $slug)
            ->with('category')
            ->firstOrFail();

        return view('frontend.product.detail', compact('product'));
    }
}
