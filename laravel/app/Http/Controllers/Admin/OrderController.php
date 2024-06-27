<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

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

    public function getOnlineRevenueByMonth(Request $request)
    {
        $year = $request->input('year');
        $onlineRevenueByMonth = $this->orderService->getOnlineRevenueByMonth($year);
        return response()->json($onlineRevenueByMonth);
    }

    public function getOfflineRevenueByMonth(Request $request)
    {
        $year = $request->input('year');
        $offlineRevenueByMonth = $this->orderService->getOfflineRevenueByMonth($year);
        return response()->json($offlineRevenueByMonth);
    }
}
