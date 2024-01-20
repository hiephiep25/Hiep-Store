<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getRevenueByMonth()
    {
        $currentYear = now()->year;

        $revenueByMonth = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total_revenue')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();

        return $revenueByMonth;
    }
}
