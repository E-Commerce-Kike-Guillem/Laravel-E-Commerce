<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;

class ProductImportController extends Controller
{
    // 1. Mostrar el formulari
    public function show()
    {
        return view('admin.import');
    }

    public function import(Request $request)
{
    // RESPUESTA DE PRUEBA: Si llega aquí, el 404/redirección desaparece
    return response()->json(['status' => 'Llegamos al controlador'], 200);
}

    // 2. Processar l'Excel
    public function store(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    try {
        $import = new ProductsImport();
        Excel::import($import, $request->file('file'));
        
        Log::info("Importación exitosa.");
        
        // DEVOLVER JSON, NO back()
        return response()->json([
            'message' => "S'han importat correctament!", 
            'rows' => $import->rows
        ], 200);

    } catch (\Exception $e) {
        Log::error("Error: " . $e->getMessage());
        // DEVOLVER JSON, NO back()
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}