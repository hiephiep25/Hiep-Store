<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StoreService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreController extends Controller
{
    public $storeService;

    public function __construct(StoreService $storeService)
    {
        $this->storeService = $storeService;
    }

    public function getStores(Request $request)
    {
        $params = $request->only(['store', 'per_page']);
        $stores = $this->storeService->getStores($params);
        return JsonResource::collection($stores);
    }
    public function create(Request $request): JsonResource
    {
        $storeData = $request->only(['address', 'phone', 'status']);
        $store = $this->storeService->create($storeData);
        return new JsonResource($store);
    }

    public function show(int $id): JsonResource
    {
        $store = $this->storeService->findstoreById($id);
        return new JsonResource($store);
    }

    public function update(int $id, Request $request): JsonResource
    {
        $storeData = $request->only(['address', 'phone', 'status']);
        $store = $this->storeService->update($id, $storeData);
        return new JsonResource($store);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|exists:products,code',
            'add_quantity' => 'nullable|integer|min:0',
            'sub_quantity' => 'nullable|integer|min:0',
            'store' => 'required',
        ]);

        $data = $request->only(['product_code', 'add_quantity', 'sub_quantity', 'store']);

        $this->storeService->storeProductInStore($data);

        return $this->success();
    }
}
