<?php

namespace App\Http\Controllers;

use App\Actions\product\getAllProducts;
use App\Actions\product\getProduct;
use App\Actions\product\updateProduct;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * @param getAllProducts $allProducts
     * @return ProductCollection
     */
    public function index(getAllProducts $allProducts):ProductCollection
    {
        return ProductCollection::make($allProducts->execute());
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * @param Product $product
     * @param getProduct $getProduct
     * @return ProductResource
     */
    public function edit(Product $product ,getProduct $getProduct):ProductResource
    {
       return ProductResource::make($getProduct->execute($product->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product,updateProduct $updateProduct)
    {
        if ($updateProduct->execute($product,$request->validated())){
            return response()->json(['message'=>'updated']);
        }
        return response()->json(['message'=>'an error happend']);
    }
}
