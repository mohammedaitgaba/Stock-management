<?php

namespace App\Actions\Recipe;

use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class storeNewRecipe
{
    /**
     * @throws \Exception
     */
    public function execute(Recipe $recipe, array $attributes): array
    {
        $attachData = [];
        foreach ($attributes['products_info'] as $productInfo) {
            $productId = $productInfo['product_id'];
            $quantity = $productInfo['quantity'];
            //format data so we can sync products id and quantity
            $attachData[$productId] = ['quantity' => $quantity];
        }
//        here we handle product stock
        foreach ($attachData as $productId => $data) {
            try {
                $product = Product::findOrFail($productId);

                // Ensure the product quantity doesn't go below zero
                if ($product->quantity < $data['quantity']) {
                    throw new \Exception('Insufficient product quantity');
                }

                $product->decrement('quantity', $data['quantity']);
            } catch (ModelNotFoundException $e) {
                // Handle the case where the product is not found
                throw new \Exception('Product not found');
            }
        }
        return $recipe->products()->sync($attachData);
    }
}
