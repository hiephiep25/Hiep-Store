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

        if ($data['quantity'] > $product->qty) {
            throw new \Exception('This product has an insufficient quantity');
        }
        \Log::info($data);
        $storage = Storage::updateOrCreate(
            [
                'product_code' => $data['product_code'],
            ],
            [
                'storage' => $data['storage'],
                'quantity' => $data['quantity'],
            ]
        );

        return $storage;
    }
}
