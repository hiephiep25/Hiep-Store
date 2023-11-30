<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['name', 'code', 'brand', 'category', 'per_page']);
        $products = $this->productService->get($params);
        return JsonResource::collection($products);
    }

    public function getCategories()
    {
        $categories = $this->productService->getCategories();
        return new JsonResource($categories);
    }

    public function create(ProductCreateRequest $request): JsonResource
    {
        $productData = $request->only(['code', 'name', 'brand','category', 'description', 'qty', 'price_per_qty', 'manufacture_day', 'expiry_day', 'image']);
        $product = $this->productService->create($productData);
        return new JsonResource($product);
    }

    public function show(int $id): JsonResource
    {
        $product = $this->productService->findProductById($id);
        return new JsonResource($product);
    }

    public function update(string $id, ProductUpdateRequest $request): JsonResource
    {
        $productData = $request->only(['code', 'name', 'brand','category', 'description', 'qty', 'price_per_qty', 'manufacture_day', 'expiry_day', 'image']);
        $product = $this->productService->update($id, $productData);
        return new JsonResource($product);
    }

    public function delete(int $id)
    {
        $this->productService->delete($id);

        return $this->success();
    }
}
