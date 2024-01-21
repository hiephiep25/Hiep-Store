<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    public $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['name', 'per_page']);
        $categories = $this->categoryService->get($params);
        return JsonResource::collection($categories);
    }

    public function create(CategoryCreateRequest $request): JsonResource
    {
        $categoryData = $request->only(['name']);
        $category = $this->categoryService->create($categoryData);
        return new JsonResource($category);
    }

    public function show(int $id): JsonResource
    {
        $user = $this->categoryService->findCategoryById($id);
        return new JsonResource($user);
    }

    public function update(string $id, CategoryUpdateRequest $request): JsonResource
    {
        $categoryData = $request->only(['name']);
        $category = $this->categoryService->update($id, $categoryData);
        return new JsonResource($category);
    }

    public function delete(int $id)
    {
        $this->categoryService->delete($id);

        return $this->success();
    }
}
