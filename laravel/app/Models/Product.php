<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category'
    ];

    public function comments()
{
    return $this->hasMany(Comment::class)->latest(); // latest() los ordena por los más recientes primero
}
}