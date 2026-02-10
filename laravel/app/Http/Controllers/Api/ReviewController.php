<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($productId)
    {
        // Retornarà reviews d'un producte
        return response()->json(['message' => "Llistat de reviews del producte $productId"]);
    }

    public function store(Request $request)
    {
        // Guardarà una review
        return response()->json(['message' => 'Review guardada correctament'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
