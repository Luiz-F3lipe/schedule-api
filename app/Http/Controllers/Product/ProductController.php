<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(path: '/products', operationId: 'listProducts', summary: 'List products', security: [['sanctum' => []]], tags: ['Products'], responses: [new OA\Response(response: 200, description: 'Product list', content: new OA\JsonContent(ref: '#/components/schemas/ProductCollection')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden')])]
    public function index()
    {
        return ProductResource::collection(
            Product::all()
        );
    }

    #[OA\Post(path: '/products', operationId: 'createProduct', summary: 'Create a product', security: [['sanctum' => []]], tags: ['Products'], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProductRequest')), responses: [new OA\Response(response: 201, description: 'Product created', content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        return ProductResource::make(Product::create($data));
    }

    #[OA\Get(path: '/products/{product}', operationId: 'showProduct', summary: 'Show a product', security: [['sanctum' => []]], tags: ['Products'], parameters: [new OA\Parameter(name: 'product', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], responses: [new OA\Response(response: 200, description: 'Product details', content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found')])]
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    #[OA\Put(path: '/products/{product}', operationId: 'updateProduct', summary: 'Update a product', security: [['sanctum' => []]], tags: ['Products'], parameters: [new OA\Parameter(name: 'product', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))], requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/ProductRequest')), responses: [new OA\Response(response: 200, description: 'Product updated', content: new OA\JsonContent(ref: '#/components/schemas/ProductResource')), new OA\Response(response: 401, description: 'Unauthenticated'), new OA\Response(response: 403, description: 'Forbidden'), new OA\Response(response: 404, description: 'Not found'), new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse'))])]
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

        return ProductResource::make($product);
    }
}
