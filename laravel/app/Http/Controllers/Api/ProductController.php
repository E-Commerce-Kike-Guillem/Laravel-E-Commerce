<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filtre per categoria
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // Filtre de cerca (q)
        if ($request->has('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Retornem amb paginació de 10 elements
        return ProductResource::collection($query->paginate(50));
    }

    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id));
    }
}