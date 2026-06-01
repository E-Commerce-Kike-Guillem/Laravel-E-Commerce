<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource; 

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('productes.index', compact('products'));
    }

    public function apiIndex(Request $request)
    {
        $query = Product::query();

        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(10);

        return ProductResource::collection($products);
    }

    public function apiShow($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }
}