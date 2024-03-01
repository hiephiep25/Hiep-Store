<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OfflineOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfflineOrderController extends Controller
{
    protected $offlineOrderService;

    public function __construct(OfflineOrderService $offlineOrderService)
    {
        $this->offlineOrderService = $offlineOrderService;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $offlineOrders = $this->offlineOrderService->getAllOfflineOrders($params);
        return JsonResource::collection($offlineOrders);
    }

    public function getStoreProducts($store)
    {
        $productCodes = $this->offlineOrderService->getStoreProducts($store);
        return JsonResource::collection($productCodes);
    }

    public function getOfflineOrderDetail($id)
    {
        $detail = $this->offlineOrderService->getOfflineOrderDetail($id);
        return $detail;
    }

    public function store(Request $request, $storage)
    {
        try {
            $data = $request->all();
            $data['storage'] = $storage;
            $order = $this->offlineOrderService->createOfflineOrder($data);

            return new JsonResource($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
