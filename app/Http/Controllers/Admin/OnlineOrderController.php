<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OnlineOrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OnlineOrderController extends Controller
{
    protected $onlineOrderService;

    public function __construct(OnlineOrderService $onlineOrderService)
    {
        $this->onlineOrderService = $onlineOrderService;
    }

    public function index(Request $request)
    {
        $params = $request->all();
        $onlineOrders = $this->onlineOrderService->getAllOnlineOrders($params);
        return JsonResource::collection($onlineOrders);
    }

    public function getOnlineOrderDetail($id)
    {
        $detail = $this->onlineOrderService->getOnlineOrderDetail($id);
        return $detail;
    }
}
