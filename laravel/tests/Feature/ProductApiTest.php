<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;

class ProductApiTest extends TestCase
{
    use RefreshDatabase; 

    public function test_api_returns_products_list_json()
    {
        Product::create(['sku' => '001', 'name' => 'Prod A', 'price' => 10, 'stock' => 5]);
        Product::create(['sku' => '002', 'name' => 'Prod B', 'price' => 20, 'stock' => 5]);
        Product::create(['sku' => '003', 'name' => 'Prod C', 'price' => 30, 'stock' => 5]);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200) 
                 ->assertJsonCount(3, 'data') 
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'sku', 'name', 'price', 'stock', 'img'] 
                     ]
                 ]);
    }

    public function test_api_can_show_single_product()
    {
        $product = Product::create(['sku' => 'TEST', 'name' => 'Test Item', 'price' => 99.99, 'stock' => 1]);

        $response = $this->getJson("/api/products/{$product->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Test Item']);
    }
}