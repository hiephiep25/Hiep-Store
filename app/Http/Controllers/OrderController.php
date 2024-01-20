<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderController extends Controller
{
    public $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getRevenueByMonth()
    {
        $revenueByMonth = $this->orderService->getRevenueByMonth();

        return response()->json($revenueByMonth);
    }
}
