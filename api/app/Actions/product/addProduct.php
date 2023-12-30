<?php

namespace App\Actions\product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class addProduct
{
    public function execute(array $attributes): Model|Builder
    {
        return Product::query()->create($attributes);
    }
}
