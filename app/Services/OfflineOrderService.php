<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Models\OfflineOrder;
use App\Models\Order;
use App\Models\ProductStore;
use App\Models\Staff;
use App\Models\Manager;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\OrderProduct;
use App\Services\NotificationService;

class OfflineOrderService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getAllOfflineOrders(array $params): LengthAwarePaginator
    {
        $role = auth()->user()->role;
        $perPage = $params['per_page'] ?? PER_PAGE;
        if($role == User::ROLE_STAFF) {
            $staff = Staff::where('user_id', auth()->id())->firstOrFail();
            $storeID = $staff->store_id;

            $query = OfflineOrder::with('order')
                ->join('orders', 'offline_orders.order_id', '=', 'orders.id')
                ->where('orders.store_id', $storeID)
                ->orderBy('offline_orders.id', 'asc');

            if (isset($params['from']) && isset($params['to'])) {
                $query->whereBetween('offline_orders.created_at', [$params['from'], $params['to']]);
            } else {
                if (isset($params['from'])) {
                    $query->where('offline_orders.created_at', '>=', $params['from']);
                } elseif (isset($params['to'])) {
                    $query->where('offline_orders.created_at', '<=', $params['to']);
                }
            }

            return $query->paginate($perPage);
        }
        if($role == User::ROLE_MANAGER) {
            $manager = Manager::where('user_id', auth()->id())->firstOrFail();
            $storeID = $manager->store_id;

            $query = OfflineOrder::with('order')
                ->join('orders', 'offline_orders.order_id', '=', 'orders.id')
                ->where('orders.store_id', $storeID)
                ->orderBy('offline_orders.id', 'asc');

            if (isset($params['from']) && isset($params['to'])) {
                $query->whereBetween('offline_orders.created_at', [$params['from'], $params['to']]);
            } else {
                if (isset($params['from'])) {
                    $query->where('offline_orders.created_at', '>=', $params['from']);
                } elseif (isset($params['to'])) {
                    $query->where('offline_orders.created_at', '<=', $params['to']);
                }
            }

            return $query->paginate($perPage);
        }
        if($role == User::ROLE_ADMIN) {

            $query = OfflineOrder::with('order')->orderBy('id', 'asc');

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


    public function getStoreProducts()
    {
        $role = auth()->user()->role;
        if($role == User::ROLE_STAFF) {
            $staff = Staff::where('user_id', auth()->id())->firstOrFail();
            $storeID = $staff->store_id;

            return ProductStore::with('product')
                ->where('store_id', $storeID)
                ->get();
        }
        if($role == User::ROLE_ADMIN) {
            return Product::all();
        }
    }

    public function createOfflineOrder(array $data)
    {
        DB::beginTransaction();
        $staff = Staff::where('user_id', auth()->id())->firstOrFail();
        $storeID = $staff->store_id;
        try {
            $order = Order::create([
                'type' => Order::OFFLINE,
                'payment_type' => $data['payment_type'],
                'total' => $data['total'],
                'store_id'=> $storeID
            ]);

            $offlineOrder = OfflineOrder::create([
                'order_id' => $order->id,
                'staff_id' => auth()->id()
            ]);

            foreach ($data['products'] as $productData) {
                $product = ProductStore::where('product_code', $productData['product_code'])->first();
                $prod = Product::where('code', $productData['product_code'])->first();
                if ($product) {
                    if ($product->qty < $productData['qty']) {
                        throw new \Exception("Số lượng sản phẩm không còn đủ để tạo đơn hàng: {$prod->code}");
                    }

                    if (!$prod->availability) {
                        throw new \Exception("Sản phẩm không khả dụng: {$prod->code}");
                    }
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_code' => $product->code,
                        'qty' => $productData['qty'],
                    ]);

                    $this->decreaseProductQuantity($product->code, $productData['qty']);
                    $this->notificationService->createNotification(1, 'create-offline-order');
                    $managers = Manager::where('store_id', $storeID)->get();
                    foreach ($managers as $manager) {
                        $this->notificationService->createNotification($manager->user_id, 'create-offline-order');
                    }
                }
            }

            DB::commit();

            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function decreaseProductQuantity($productCode, $quantity)
    {
        ProductStore::where('product_code', $productCode)->decrement('qty', $quantity);
        Product::where('code', $productCode)->decrement('qty', $quantity);
    }

    public function getOfflineOrderDetail(int $orderId)
    {
        $offlineOrder = Order::with('products')->findOrFail($orderId);
        return $offlineOrder;
    }
}
