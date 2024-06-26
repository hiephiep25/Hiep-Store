<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\DiscountUpdateRequest;
use App\Http\Requests\Discount\DiscountCreateRequest;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailDiscount;

class DiscountController extends Controller
{
    public $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['name', 'code', 'per_page']);
        $discounts = $this->discountService->get($params);
        return JsonResource::collection($discounts);
    }

    public function create(DiscountCreateRequest $request): JsonResource
    {
        $discountData = $request->only(['name', 'code', 'description', 'start', 'end', 'image']);
        $discount = $this->discountService->create($discountData);
        return new JsonResource($discount);
    }

    public function show(int $id): JsonResource
    {
        $discount = $this->discountService->findDiscountById($id);
        return new JsonResource($discount);
    }

    public function update(string $id, DiscountUpdateRequest $request): JsonResource
    {
        $discountData = $request->only(['name', 'code', 'description', 'start', 'end', 'image']);
        $discount = $this->discountService->update($id, $discountData);
        return new JsonResource($discount);
    }

    public function delete(int $id)
    {
        $this->discountService->delete($id);

        return $this->success();
    }

    public function updateDiscountProducts(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        if($discount->start < Carbon::now()->subDays(1)) {
            throw new \Exception('Không thể chỉnh sửa discount này nữa');
        }
        $products = $request->all();

        $syncData = [];
        foreach ($products as $product) {
            if (isset($product['pivot'])) {
                $syncData[$product['id']] = [
                    'value' => $product['pivot']['value'],
                    'qty' => $product['pivot']['qty'],
                ];
            }
        }

        $discount->products()->sync($syncData);

        return response()->json(['message' => 'Cập nhật thành công']);
    }

    public function sendDiscountEmail($id) {
        $discount = Discount::with('products')->findOrFail($id);
        if($discount->end < Carbon::now()) {
            throw new \Exception('Discount đã quá hạn');
        }
        $users = User::where('role', User::ROLE_CUSTOMER)->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new SendMailDiscount($discount));
        }

        return response()->json(['message' => 'Email đã được gửi thành công']);
    }
}
