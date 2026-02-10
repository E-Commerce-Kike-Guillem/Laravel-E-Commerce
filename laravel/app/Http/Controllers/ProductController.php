<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource; // <--- Importante: Importar el Resource

class ProductController extends Controller
{
    // Món WEB: Retorna una vista HTML (Esto ya lo tenías)
    public function index()
    {
        $products = Product::all();
        return view('productes.index', compact('products'));
    }

    // Món API: Llistat amb filtres i paginació
    public function apiIndex(Request $request)
    {
        // 1. Iniciem la consulta
        $query = Product::query();

        // 2. Filtre de cerca (?q=cafetera)
        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('description', 'LIKE', "%{$searchTerm}%");
        }

        // 3. Filtre per categoria (Opcional: només si vas afegir la columna 'category')
        // if ($request->has('category')) {
        //     $query->where('category', $request->category);
        // }

        // 4. Paginació (10 productes per pàgina)
        $products = $query->paginate(10);

        // 5. Retornem usant el Resource (normalitzat)
        return ProductResource::collection($products);
    }

    // Món API: Detall d'un sol producte
    public function apiShow($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }
}