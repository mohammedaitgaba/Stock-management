<?php

namespace App\Http\Resources\Recipe;

use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReciepeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'products' => ProductCollection::collection($this->whenLoaded('products')),
        ];
    }
}
