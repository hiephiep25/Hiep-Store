<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $code = $params['code'] ?? '';
        $brand = $params['brand'] ?? '';
        $category = $params['category'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Product::where(function ($query) use ($name, $code, $brand, $category) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
            if (!empty($code)) {
                $query->where('code', 'like', "%$code%");
            }
            if (!empty($brand)) {
                $query->where('brand', 'like', "%$brand%");
            }
            if (!empty($category)) {
                $query->where('category', $category);
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function create(array $data): Product
    {
        $directory = '/public/products/' . Str::slug($data['code']);
        $name = $data['image']->getClientOriginalName();
        $path = Storage::putFileAs($directory, $data['image'], $name);

        $data['image'] = url(Storage::url($path));

        $product = Product::create([
            ...$data,
        ]);

        return $product;
    }

    public function findProductById(int $id)
    {
        return Product::findOrFail($id);
    }

    public function update(int $id, array $productData): Product
    {
        $product = $this->findProductById($id);
        if (!empty($productData['image'])) {
            $imagePath = str_replace(url('/storage'), '', $product->image);
            $image = public_path('storage' . $imagePath);
            if (file_exists($image)) {
                unlink($image);
            }

            $directory = '/public/products/' . Str::slug($productData['code']);
            $name = $productData['image']->getClientOriginalName();
            $path = Storage::putFileAs($directory, $productData['image'], $name);

            $productData['image'] = url(Storage::url($path));
        }

        $product->update($productData);

        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->findProductById($id);
        $product->delete();
    }
}
