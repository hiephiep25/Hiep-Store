<?php

namespace App\Services;

use App\Models\Discount;
use Illuminate\Pagination\LengthAwarePaginator;

class DiscountService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $code = $params['code'] ?? '';
        $value = $params['value'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Discount::where(function ($query) use ($name, $code, $value) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
            if (!empty($code)) {
                $query->where('code', 'like', "%$code%");
            }
            if (!empty($value)) {
                $query->where('value', $value);
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }
    public function create(array $data): Discount
    {
        $discount = Discount::create([
            ...$data,
        ]);

        return $discount;
    }

    public function findDiscountById(int $id)
    {
        return Discount::findOrFail($id);
    }

    public function update(int $id, array $discountData): Discount
    {
        $discount = $this->findDiscountById($id);
        $discount->update($discountData);

        return $discount;
    }

    public function delete(int $id)
    {
        $discount = $this->findDiscountById($id);
        $discount->delete();
    }
}
