<?php

namespace App\Services;

use App\Models\User;
use App\Models\Process;
use App\Models\Product;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\NotificationService;

class ProcessService
{
    private NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

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
        if($product->qty < $data['qty']) {
            throw new Exception("Số lượng sản phẩm xử lí không còn đủ");
        }
        $product->qty -= $data['qty'];
        $product->save();

        $managers = User::where('role', User::ROLE_MANAGER)->get();

        foreach ($managers as $manager) {
            $this->notificationService->createNotification($manager->id, 'process');
        }

        return $process;
    }

    public function findProcessById(int $id)
    {
        return Process::findOrFail($id);
    }
}
