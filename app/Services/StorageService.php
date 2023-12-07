<?php

namespace App\Services;

use App\Models\Storage;
use App\Models\Product;

class StorageService
{
    public function getStorages()
    {
        return Storage::all();
    }

    public function storeProductInStorage($data)
    {
        $product = Product::where('code', $data['product_code'])->firstOrFail();

        if ($data['quantity'] > $product->qty) {
            return 'This product has an insufficient quantity';
        }

        $storage = Storage::updateOrCreate(
            [
                'storage' => $data['storage'],
                'product_code' => $data['product_code'],
            ],
            [
                'quantity' => $data['quantity'],
            ]
        );

        return $storage;
    }
}
