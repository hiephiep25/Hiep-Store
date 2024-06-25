<?php

namespace App\Services;

use App\Models\Discount;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DiscountService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $code = $params['code'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Discount::where(function ($query) use ($name, $code) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
            if (!empty($code)) {
                $query->where('code', 'like', "%$code%");
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }
    
    public function create(array $data): Discount
    {
        $directory = 'public/discounts/' . Str::slug($data['code']);
        $name = $data['image']->getClientOriginalName();
        $path = Storage::putFileAs($directory, $data['image'], $name);

        $data['image'] = str_replace('public/', 'storage/', $path);

        $discount = Discount::create($data);

        return $discount;
    }

    public function findDiscountById(int $id)
    {
        return Discount::findOrFail($id);
    }

    public function update(int $id, array $discountData): Discount
    {
        $discount = $this->findDiscountById($id);
        if (!empty($discountData['image'])) {
            $oldDirectory = 'public/discounts/' . Str::slug($discount->code);
            Storage::deleteDirectory($oldDirectory);

            $directory = 'public/discounts/' . Str::slug($discountData['code']);
            $name = $discountData['image']->getClientOriginalName();
            $path = Storage::putFileAs($directory, $discountData['image'], $name);

            $discountData['image'] = str_replace('public/', 'storage/', $path);
        }

        $discount->update($discountData);

        return $discount;
    }

    public function delete(int $id)
    {
        $discount = $this->findDiscountById($id);
        $directory = 'public/discounts/' . Str::slug($discount->code);
        Storage::deleteDirectory($directory);
        $discount->delete();
    }
}
