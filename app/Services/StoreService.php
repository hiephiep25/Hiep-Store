<?php

namespace App\Services;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class StoreService
{
    public function getStores(array $params): LengthAwarePaginator
    {
        $store = $params['store'];
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Store::where('store', $store)->orderBy('id', 'asc')->paginate($perPage);
    }

    public function storeProductInStore($data)
    {
        $product = Product::where('code', $data['product_code'])->firstOrFail();
        if (!empty($data['add_quantity']) && !empty($data['sub_quantity'])) {
            throw new \Exception('Both add_quantity and sub_quantity cannot have values at the same time');
        }

        if (empty($data['add_quantity']) && empty($data['sub_quantity'])) {
            throw new \Exception('Please add or sub quantity of product');
        }

        $totalQuantityInStore = $product->stores()->sum('quantity');

        if (!empty($data['add_quantity'])) {
            $totalQuantityInStore += $data['add_quantity'];
        }

        if ($totalQuantityInStore > $product->qty) {
            throw new \Exception('Not enough quantity of products');
        }

        $store = Store::where('store', $data['store'])
                        ->where('product_code', $data['product_code'])
                        ->first();

        if(!$store) {
            if(!empty($data['sub_quantity'])) {
                throw new \Exception('Quantity cannot be subtracted');
            }
            $storeNew = Store::create([
                'store' => $data['store'],
                'product_code' => $data['product_code'],
                'quantity' => $data['add_quantity'],
            ]);

            return $storeNew ;
        } elseif( ($data['sub_quantity']) >= $store->quantity) {
            throw new \Exception('Sub_quantity can not greater than quantity');
        } elseif(!empty($data['add_quantity'])){
            $newQuantity = $store->quantity + $data['add_quantity'];
            $store = $store->update([
                'quantity' =>  $newQuantity,
            ]);
            return $store;
        } else {
            $newQuantity = $store->quantity - $data['sub_quantity'];
            $store = $store->update([
                'quantity' =>  $newQuantity,
            ]);
            return $store;
        }
    }
}
