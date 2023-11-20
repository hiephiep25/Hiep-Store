<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $params = $request->only(['name', 'email', 'per_page']);
        $users = $this->userService->get($params);
        return JsonResource::collection($users);
    }

    public function profile()
    {
        return new JsonResource($this->userService->profile());
    }

    public function create(UserCreateRequest $request): JsonResource
    {
        $userData = $request->only(['name', 'email', 'password', 'role']);
        $user = $this->userService->create($userData);
        return new JsonResource($user);
    }

    public function show(int $id): JsonResource
    {
        $user = $this->userService->findUserById($id);
        return new JsonResource($user);
    }

    public function update(string $id, UserUpdateRequest $request): JsonResource
    {
        $userData = $request->only(['name', 'email', 'password', 'role']);
        $user = $this->userService->update($id, $userData);
        return new JsonResource($user);
    }

    public function delete(int $id)
    {
        $this->userService->delete($id);

        return $this->success();
    }
}
