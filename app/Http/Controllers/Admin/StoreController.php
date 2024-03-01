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
