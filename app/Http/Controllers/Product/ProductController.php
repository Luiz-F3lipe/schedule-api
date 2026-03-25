<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return ProductResource::collection(
            Product::all()
        );
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        return ProductResource::make(Product::create($data));
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

        return ProductResource::make($product);
    }
}
