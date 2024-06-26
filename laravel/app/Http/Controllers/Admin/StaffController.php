<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StaffService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffController extends Controller
{
    public $staffService;

    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page']);
        $staffs = $this->staffService->get($params);
        return JsonResource::collection($staffs);
    }

    public function show(int $id): JsonResource
    {
        $user = $this->staffService->findUserById($id);
        return new JsonResource($user);
    }

    public function update(int $id, Request $request): JsonResource
    {
        $staffData = $request->only('status');
        $staff = $this->staffService->update($id, $staffData);
        return new JsonResource($staff);
    }
}
