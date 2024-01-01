<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'product';
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
            'description' => $this->description,
            'quantity'=>$this->quantity,
            'weight'=>$this->weight,
            'expiring_date'=>$this->expiring_date,
            'quantityInReciep' => $this->whenPivotLoaded('recipe_products', function () {
                return $this->pivot->quantity;
            }),
        ];
    }
}
