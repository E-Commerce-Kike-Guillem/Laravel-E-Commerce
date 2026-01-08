<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Camps que permetem omplir massivament
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'image',
    ];
}