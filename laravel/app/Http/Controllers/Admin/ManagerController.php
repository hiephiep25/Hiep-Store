<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerController extends Controller
{
    public $managerService;

    public function __construct(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['per_page']);
        $managers = $this->managerService->get($params);
        return JsonResource::collection($managers);
    }

    public function show(int $id): JsonResource
    {
        $user = $this->managerService->findUserById($id);
        return new JsonResource($user);
    }

    public function update(int $id, Request $request): JsonResource
    {
        $managerData = $request->only(['store_id']);
        $manager = $this->managerService->update($id, $managerData);
        return new JsonResource($manager);
    }
}
