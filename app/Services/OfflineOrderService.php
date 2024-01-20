<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Models\OfflineOrder;
use App\Models\Order;
use App\Models\Storage;
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
        $perPage = $params['per_page'] ?? PER_PAGE;

        $query = OfflineOrder::with('order')->orderBy('id', 'asc');

        if (isset($params['from']) && isset($params['to'])) {
            $query->whereBetween('created_at', [$params['from'], $params['to']]);
        }
        if (isset($params['storage'])) {
            $query->where('storage', $params['storage']);
        }

        return $query->paginate($perPage);
    }

    public function getStorageProducts(int $storage)
    {
        return Storage::with('product')
            ->where('storage', $storage)
            ->get();
    }

    public function createOfflineOrder(array $data)
    {
        DB::beginTransaction();
        try {
            $order = Order::create([
                'type' => Order::OFFLINE,
                'payment_type' => $data['payment_type'],
                'total' => $data['total'],
            ]);

            $offlineOrder = OfflineOrder::create([
                'order_id' => $order->id,
                'storage' => $data['storage'],
            ]);

            foreach ($data['products'] as $productData) {
                $product = Product::where('code', $productData['product_code'])->first();

                if ($product) {
                    if ($product->qty < $productData['qty']) {
                        throw new \Exception("Insufficient quantity in storage for product: {$product->code}");
                    }
                    OrderProduct::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_code' => $product->code,
                        'qty' => $productData['qty'],
                    ]);

                    $this->decreaseProductQuantity($product->code, $productData['qty']);
                    $this->notificationService->createNotification(2, 'create-offline-order');
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
        Storage::where('product_code', $productCode)->decrement('quantity', $quantity);
        Product::where('code', $productCode)->decrement('qty', $quantity);
    }

    public function getOfflineOrderDetail(int $orderId)
    {
        $offlineOrder = Order::with('products')->findOrFail($orderId);
        return $offlineOrder;
    }
}
