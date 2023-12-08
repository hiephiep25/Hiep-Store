<?php

namespace App\Services;

use App\Models\Storage;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class StorageService
{
    public function getStorages(array $params): LengthAwarePaginator
    {
        $storage = $params['storage'];
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Storage::where('storage', $storage)->orderBy('id', 'asc')->paginate($perPage);
    }

    public function storeProductInStorage($data)
    {
        $product = Product::where('code', $data['product_code'])->firstOrFail();
        if (!empty($data['add_quantity']) && !empty($data['sub_quantity'])) {
            throw new \Exception('Both add_quantity and sub_quantity cannot have values at the same time');
        }

        if (empty($data['add_quantity']) && empty($data['sub_quantity'])) {
            throw new \Exception('Please add or sub quantity of product');
        }

        $totalQuantityInStorage = $product->storages()->sum('quantity');

        if (!empty($data['add_quantity'])) {
            $totalQuantityInStorage += $data['add_quantity'];
        }

        if ($totalQuantityInStorage > $product->qty) {
            throw new \Exception('Not enough quantity of products');
        }

        $storage = Storage::where('storage', $data['storage'])
                        ->where('product_code', $data['product_code'])
                        ->first();

        if(!$storage) {
            if(!empty($data['sub_quantity'])) {
                throw new \Exception('Quantity cannot be subtracted');
            }
            $storageNew = Storage::create([
                'storage' => $data['storage'],
                'product_code' => $data['product_code'],
                'quantity' => $data['add_quantity'],
            ]);

            return $storageNew ;
        } elseif( ($data['sub_quantity']) >= $storage->quantity) {
            throw new \Exception('Sub_quantity can not greater than quantity');
        } elseif(!empty($data['add_quantity'])){
            $newQuantity = $storage->quantity + $data['add_quantity'];
            $storage = $storage->update([
                'quantity' =>  $newQuantity,
            ]);
            return $storage;
        } else {
            $newQuantity = $storage->quantity - $data['sub_quantity'];
            $storage = $storage->update([
                'quantity' =>  $newQuantity,
            ]);
            return $storage;
        }
    }
}
