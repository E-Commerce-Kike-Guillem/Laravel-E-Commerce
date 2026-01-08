<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product; // Importar el model!

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Creem productes d'exemple
        Product::create([
            'sku' => 'A001',
            'name' => 'Cafetera Premium',
            'description' => 'Cafetera automàtica amb molinet integrat',
            'price' => 129.99,
            'stock' => 15,
            'image' => 'img/cafetera.jpg'
        ]);

        Product::create([
            'sku' => 'A002',
            'name' => 'Tetera Elèctrica',
            'description' => 'Tetera ràpida acer inoxidable',
            'price' => 59.95,
            'stock' => 10,
            'image' => 'img/tetera.jpg'
        ]);
        
        Product::create([
            'sku' => 'GEN-003',
            'name' => 'Auriculars Bluetooth',
            'description' => 'Cancel·lació de soroll activa',
            'price' => 89.90,
            'stock' => 50,
            'image' => 'img/auriculars.jpg'
        ]);
    }
}