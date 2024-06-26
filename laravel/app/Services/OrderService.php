<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getRevenueByMonth($year)
    {
        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return $revenueByMonth;
    }

    public function getOnlineRevenueByMonth($year)
    {
        $onlineRevenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', $year)
            ->where('type', Order::ONLINE)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return $onlineRevenueByMonth;
    }

    public function getOfflineRevenueByMonth($year)
    {
        $offlineRevenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', $year)
            ->where('type', Order::OFFLINE)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return $offlineRevenueByMonth;
    }
}
