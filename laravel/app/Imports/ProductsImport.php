<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Log;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public $rows = 0;

    public function model(array $row)
{
    // CUIDADO: Los nombres dentro de $row['nombre_columna'] 
    // DEBEN coincidir exactamente con los nombres de la primera fila de tu Excel.
    
    return new Product([
        'sku'         => $row['sku'],
        'name'        => $row['name'],
        'description' => $row['description'],
        'price'       => $row['price'],
        'stock'       => $row['stock'],
        'image'       => $row['image'],    // <-- ¿Está este campo?
        'category'    => $row['category'], // <-- ¿Está este campo?
    ]);
}

    public function rules(): array
    {
        return [
            'sku'   => 'required', 
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ];
    }
}