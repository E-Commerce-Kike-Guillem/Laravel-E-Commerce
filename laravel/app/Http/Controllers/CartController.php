<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem; // Asegúrate de tener este modelo

class CartController extends Controller
{
    public function index(Request $request) {
        return $request->user()->cartItems()->with('product')->get();
    }

    public function store(Request $request) {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        return $request->user()->cartItems()->updateOrCreate(
            ['product_id' => $request->product_id],
            ['quantity' => \DB::raw('quantity + 1')]
        );
    }

    public function destroy($productId, Request $request) {
        $request->user()->cartItems()->where('product_id', $productId)->delete();
        return response()->json(['message' => 'Eliminat']);
    }
}