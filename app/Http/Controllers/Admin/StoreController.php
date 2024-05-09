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
        $params = $request->only(['per_page']);
        $stores = $this->storeService->getStores($params);
        return JsonResource::collection($stores);
    }
    public function getProductStores(Request $request)
    {
        $params = $request->only(['store_id', 'per_page']);
        $stores = $this->storeService->getProductStores($params);
        return JsonResource::collection($stores);
    }
    public function create(Request $request): JsonResource
    {
        $storeData = $request->only(['address', 'phone_contact', 'status']);
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
        $storeData = $request->only(['address', 'phone_contact', 'status']);
        $store = $this->storeService->update($id, $storeData);
        return new JsonResource($store);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'product_code' => 'required|exists:products,code',
            'add_quantity' => 'nullable|integer|min:0',
            'sub_quantity' => 'nullable|integer|min:0',
            'store_id' => 'required',
        ], [
            'product_code.required' => 'Mã sản phẩm là bắt buộc.',
            'product_code.exists' => 'Mã sản phẩm không tồn tại.',
            'add_quantity.integer' => 'Số lượng thêm phải là một số nguyên.',
            'add_quantity.min' => 'Số lượng thêm phải lớn hơn hoặc bằng 0.',
            'sub_quantity.integer' => 'Số lượng trừ phải là một số nguyên.',
            'sub_quantity.min' => 'Số lượng trừ phải lớn hơn hoặc bằng 0.',
            'store_id.required' => 'ID cửa hàng là bắt buộc.',
        ]);

        $data = $request->only(['product_code', 'add_quantity', 'sub_quantity', 'store_id']);

        $this->storeService->storeProductInStore($data);

        return $this->success();
    }
}
