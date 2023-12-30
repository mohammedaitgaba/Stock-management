<?php

namespace App\Actions\product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class getAllProducts
{
    public function execute(): Collection|array
    {
        return Product::query()->get();
    }
}
