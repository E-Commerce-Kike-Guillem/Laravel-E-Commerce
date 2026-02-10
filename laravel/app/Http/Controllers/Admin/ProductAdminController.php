<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')
                         ->with('success', 'Producte actualitzat correctament!');
    }

    // Opcional: Destroy per esborrar
    public function destroy($id)
    {
        Product::destroy($id);
        return back()->with('success', 'Producte eliminat.');
    }
}