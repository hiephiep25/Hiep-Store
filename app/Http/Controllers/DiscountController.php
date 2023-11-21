<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\DiscountUpdateRequest;
use App\Http\Requests\Discount\DiscountCreateRequest;
use App\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountController extends Controller
{
    public $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['name', 'code', 'value', 'per_page']);
        $discounts = $this->discountService->get($params);
        return JsonResource::collection($discounts);
    }

    public function create(DiscountCreateRequest $request): JsonResource
    {
        $discountData = $request->only(['name', 'code', 'value', 'description', 'quantity', 'expiration_date']);
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
        $discountData = $request->only(['name', 'code', 'value', 'description', 'quantity', 'expiration_date']);
        $discount = $this->discountService->update($id, $discountData);
        return new JsonResource($discount);
    }

    public function delete(int $id)
    {
        $this->discountService->delete($id);

        return $this->success();
    }
}
