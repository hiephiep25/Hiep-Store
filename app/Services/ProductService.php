<?php
namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $code = $params['code'] ?? '';
        $brand = $params['brand'] ?? '';
        $category = $params['category_id'] ?? '';
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
                $query->where('category_id', $category);
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }

    public function getAvailable(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $code = $params['code'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Product::available()->where(function ($query) use ($name, $code) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
            if (!empty($code)) {
                $query->where('code', 'like', "%$code%");
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }

    public function getAllAvailable()
    {
        return Product::available()->orderBy('id', 'asc')->get();
    }

    public function getCategories()
    {
        return Category::all();
    }

    public function create(array $data): Product
    {
        $directory = 'public/products/' . Str::slug($data['code']);
        $name = $data['image']->getClientOriginalName();
        $path = Storage::putFileAs($directory, $data['image'], $name);

        $data['image'] = str_replace('public/', 'storage/', $path);

        $product = Product::create([
            ...$data
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
        $twoDaysAgo = Carbon::now()->subDays(1);
        if ($product->created_at < $twoDaysAgo) {
            throw new \Exception('Không thể chỉnh sửa sản phẩm đã tạo cách đây 1 ngày');
        }
        if (!empty($productData['image'])) {
            if ($product->image) {
                unlink( $product->image);
            }

            $directory = 'public/products/' . Str::slug($productData['code']);
            $name = $productData['image']->getClientOriginalName();
            $path = Storage::putFileAs($directory, $productData['image'], $name);

            $productData['image'] = str_replace('public/', 'storage/', $path);
        }

        $product->update($productData);

        return $product;
    }

    public function delete(int $id)
    {
        $product = $this->findProductById($id);
        if ($product->image) {
            unlink($product->image);
        }
        $product->delete();
    }
}
