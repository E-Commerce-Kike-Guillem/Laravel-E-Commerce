<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relación para que al pedir el carrito traiga el producto también
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}