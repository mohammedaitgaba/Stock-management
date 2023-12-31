<?php

namespace App\Actions\product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class getProduct
{
    public function execute(string $product_id): Model|Builder
    {
        return Product::query()->where('id', $product_id)->firstOrFail();
    }
}
