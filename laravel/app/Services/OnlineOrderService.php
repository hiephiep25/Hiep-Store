<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Models\OnlineOrder;
use App\Models\Order;
use App\Models\ProductStore;
use App\Models\Staff;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\OrderProduct;
use App\Services\NotificationService;

class OnlineOrderService
{
    public function getAllOnlineOrders(array $params): LengthAwarePaginator
    {
        $role = auth()->user()->role;
        $perPage = $params['per_page'] ?? PER_PAGE;
        if($role == User::ROLE_STAFF) {
            $staff = Staff::where('user_id', auth()->id())->firstOrFail();
            $storeID = $staff->store_id;

            $query = OnlineOrder::with('order')
                ->join('orders', 'online_orders.order_id', '=', 'orders.id')
                ->where('orders.store_id', $storeID)
                ->orderBy('online_orders.id', 'asc');

            if (isset($params['from']) && isset($params['to'])) {
                $query->whereBetween('online_orders.created_at', [$params['from'], $params['to']]);
            } else {
                if (isset($params['from'])) {
                    $query->where('online_orders.created_at', '>=', $params['from']);
                } elseif (isset($params['to'])) {
                    $query->where('online_orders.created_at', '<=', $params['to']);
                }
            }

            return $query->paginate($perPage);
        }
        if($role == User::ROLE_MANAGER) {
            $manager = Manager::where('user_id', auth()->id())->firstOrFail();
            $storeID = $manager->store_id;

            $query = OnlineOrder::with('order')
                ->join('orders', 'online_orders.order_id', '=', 'orders.id')
                ->where('orders.store_id', $storeID)
                ->orderBy('online_orders.id', 'asc');

            if (isset($params['from']) && isset($params['to'])) {
                $query->whereBetween('online_orders.created_at', [$params['from'], $params['to']]);
            } else {
                if (isset($params['from'])) {
                    $query->where('online_orders.created_at', '>=', $params['from']);
                } elseif (isset($params['to'])) {
                    $query->where('online_orders.created_at', '<=', $params['to']);
                }
            }

            return $query->paginate($perPage);
        }
        if($role == User::ROLE_ADMIN) {

            $query = OnlineOrder::with('order')->orderBy('id', 'asc');

            if (isset($params['from']) && isset($params['to'])) {
                $query->whereBetween('created_at', [$params['from'], $params['to']]);
            } else {
                if (isset($params['from'])) {
                    $query->where('created_at', '>=', $params['from']);
                } elseif (isset($params['to'])) {
                    $query->where('created_at', '<=', $params['to']);
                }
            }

            return $query->paginate($perPage);
        }
    }

    public function getOnlineOrderDetail(int $orderId)
    {
        $onlineOrder = Order::with(['products', 'onlineOrder.user'])
            ->findOrFail($orderId);

        return $onlineOrder;
    }
}
