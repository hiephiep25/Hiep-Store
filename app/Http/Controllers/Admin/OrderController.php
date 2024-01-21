<?php

namespace App\Http\Controllers\Admin;

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

    public function getRevenueByMonth(Request $request)
    {
        $year = $request->input('year');

        $revenueByMonth = $this->orderService->getRevenueByMonth($year);

        return response()->json($revenueByMonth);
    }
}
