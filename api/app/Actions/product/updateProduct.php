<?php

namespace App\Actions\product;

use App\Models\Product;

class updateProduct
{
    public function execute(Product $product,array $attributes)
    {
        return $product->update($attributes);
    }
}
