<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Món WEB: Retorna una vista HTML
    public function index()
    {
        $products = Product::all(); // Recupera tot
        return view('productes.index', compact('products'));
    }

    // Món API: Retorna JSON
    public function apiIndex()
    {
        $products = Product::all();
        return response()->json($products);
    }
}