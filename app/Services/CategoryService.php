<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Category::where(function ($query) use ($name) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }
    
    public function create(array $data): Category
    {
        $category = Category::create([
            ...$data,
        ]);

        return $category;
    }

    public function findCategoryById(int $id)
    {
        return Category::findOrFail($id);
    }

    public function update(int $id, array $categoryData): Category
    {
        $category = $this->findCategoryById($id);
        $category->update($categoryData);

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->findCategoryById($id);
        $category->delete();
    }
}
