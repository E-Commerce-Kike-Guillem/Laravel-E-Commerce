<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductImportController extends Controller
{
    // 1. Mostrar el formulari
    public function show()
    {
        return view('admin.import');
    }

    // 2. Processar l'Excel
    public function store(Request $request)
    {
        // Validem que s'hagi pujat un fitxer i sigui Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            // La màgia de Laravel Excel
            Excel::import(new ProductsImport, $request->file('file'));
            
            return back()->with('success', 'Productes importats correctament!');
        } catch (\Exception $e) {
            // Capturem errors (de format o validació)
            return back()->with('error', 'Error importat: ' . $e->getMessage());
        }
    }
}