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
        // Validar que el archivo ha sido subido
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            // Realizar la importación usando la clase ProductsImport
            Excel::import(new ProductsImport, $request->file('file'));

            return back()->with('success', 'Productes importats correctament!');
        } catch (\Exception $e) {
            Log::error("Error en la importació: " . $e->getMessage());
            return back()->with('error', 'Error en importar el fitxer: ' . $e->getMessage());
        }
    }

    // 2. Processar l'Excel
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            $import = new ProductsImport(); // Creem la instància abans
            Excel::import($import, $request->file('file'));
            
            // Registrem al Log de Laravel (storage/logs/laravel.log)
            Log::info("Importació d'Excel: s'han importat/actualitzat {$import->rows} productes.");
            
            // Retornem el feedback a la vista amb el número exacte
            return back()->with('success', "S'han importat o actualitzat {$import->rows} productes correctament!");

        } catch (\Exception $e) {
            Log::error("Error a la importació d'Excel: " . $e->getMessage());
            return back()->with('error', 'Error important: ' . $e->getMessage());
        }
    }
}