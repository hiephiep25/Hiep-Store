<?php

namespace App\Services;

use App\Models\User;
use App\Models\Process;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProcessService
{
    public function get($params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Process::orderBy('id', 'asc')->paginate($perPage);
    }

    public function create(array $data): Process
    {
        $process = Process::create([
            ...$data,
        ]);

        $product = Product::where('code', $data['product_code'])->firstOrFail();
        $product->qty -= $data['qty'];
        $product->save();

        return $process;
    }

    
}
