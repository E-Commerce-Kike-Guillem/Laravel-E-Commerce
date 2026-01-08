<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('products', function (Blueprint $table) {
        $table->id(); // ID autoincremental
        $table->string('sku')->unique(); // Codi únic
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2); // 10 dígits total, 2 decimals
        $table->integer('stock')->default(0);
        $table->string('image')->nullable(); // Ruta de la imatge
        // $table->string('category')->nullable(); // Opcional segons l'enunciat
        $table->timestamps(); // created_at i updated_at automàtics
    });
}


};
