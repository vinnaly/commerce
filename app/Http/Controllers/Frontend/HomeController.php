<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $relatedProducts = Product::latest()->take(3)->get();
        $categories = Category::all();

        return view('frontend.home', compact('relatedProducts', 'categories'));
    }
}
