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
    
    return new Product([
        'sku'         => $row['sku'],
        'name'        => $row['name'],
        'description' => $row['description'],
        'price'       => $row['price'],
        'stock'       => $row['stock'],
        'image'       => $row['image'],    
        'category'    => $row['category'],
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