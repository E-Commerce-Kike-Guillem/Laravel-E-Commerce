<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function model(array $row)
    {
        return Product::updateOrCreate(
            ['sku' => $row['sku']],
            [
                'name'        => $row['name'],
                'description' => $row['description'] ?? '',
                'price'       => $row['price'],
                'stock'       => $row['stock'],
                'image'       => $row['image'] ?? '',
            ]
        );
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