<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = ['collars', 'anells', 'polseres', 'arracades', 'piercings'];
        
        for ($i = 1; $i <= 20; $i++) {
            $cat = $categories[array_rand($categories)];
            Product::create([
                'sku' => 'SKU-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'name' => 'Producte ' . $i . ' de ' . $cat,
                'description' => 'Aquesta és la descripció detallada del producte número ' . $i . '.',
                'price' => rand(10, 200) + 0.99,
                'stock' => rand(5, 50),
                // La ruta que pedías:
                'image' => '../../public/contenido/productos/' . $cat . '.jpg', 
                'category' => $cat,
            ]);
        }
    }
}