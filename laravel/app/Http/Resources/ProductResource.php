<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'sku'         => $this->sku,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => (float) $this->price, 
            'stock'       => (int) $this->stock,
            'img'       => $this->image ? asset($this->image) : null,
            'updated_at'  => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}