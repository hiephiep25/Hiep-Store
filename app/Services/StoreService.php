<?php

namespace App\Services;

use App\Models\Store;
use App\Models\Product;
use App\Models\ProductStore;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreService
{
    public function getStores(array $params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Store::orderBy('id', 'asc')->paginate($perPage);
    }

    public function getProductStores(array $params): LengthAwarePaginator
    {
        $store = $params['store_id'];
        $perPage = $params['per_page'] ?? PER_PAGE;
        return ProductStore::where('store_id', $store)->orderBy('id', 'asc')->paginate($perPage);
    }

    public function create(array $data): Store
    {
        $store = Store::create([
            ...$data,
        ]);

        return $store;
    }

    public function findStoreById(int $id)
    {
        return Store::findOrFail($id);
    }

    public function update(int $id, array $storeData): Store
    {
        $store = $this->findStoreById($id);
        $store->update($storeData);

        return $store;
    }

    public function storeProductInStore($data)
    {
        $product = Product::where('code', $data['product_code'])->firstOrFail();
        if (!empty($data['add_quantity']) && !empty($data['sub_quantity'])) {
            throw new \Exception('Cả hai trường "số lượng thêm" và "số lượng bớt" không thể có giá trị cùng một lúc');
        }

        if (empty($data['add_quantity']) && empty($data['sub_quantity'])) {
            throw new \Exception('Vui lòng thêm hoặc trừ số lượng sản phẩm');
        }

        $totalQuantityInStore = $product->productStores()->sum('qty');

        if (!empty($data['add_quantity'])) {
            $totalQuantityInStore += $data['add_quantity'];
        }

        if ($totalQuantityInStore > $product->qty) {
            throw new \Exception('Không đủ số lượng sản phẩm');
        }

        $store = ProductStore::where('store_id', $data['store_id'])
            ->where('product_code', $data['product_code'])
            ->first();

        if (!$store) {
            if (!empty($data['sub_quantity'])) {
                throw new \Exception('Không thể trừ số lượng');
            }
            $storeNew = ProductStore::create([
                'store_id' => $data['store_id'],
                'product_code' => $data['product_code'],
                'qty' => $data['add_quantity'],
            ]);

            return $storeNew;
        } elseif (($data['sub_quantity']) >= $store->qty) {
            throw new \Exception('Số lượng trừ không thể lớn hơn số lượng hiện có');
        } elseif (!empty($data['add_quantity'])) {
            $newQuantity = $store->qty + $data['add_quantity'];
            $store = $store->update([
                'qty' =>  $newQuantity,
            ]);
            return $store;
        } else {
            $newQuantity = $store->qty - $data['sub_quantity'];
            $store = $store->update([
                'qty' =>  $newQuantity,
            ]);
            return $store;
        }
    }
}
