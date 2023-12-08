<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageController extends Controller
{
    public $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function getStorages(Request $request)
    {
        $params = $request->only(['storage', 'per_page']);
        $storages = $this->storageService->getStorages($params);
        return JsonResource::collection($storages);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|exists:products,code',
            'add_quantity' => 'nullable|integer|min:0',
            'sub_quantity' => 'nullable|integer|min:0',
            'storage' => 'required',
        ]);

        $data = $request->only(['product_code', 'add_quantity', 'sub_quantity', 'storage']);

        $this->storageService->storeProductInStorage($data);

        return $this->success();
    }
}
