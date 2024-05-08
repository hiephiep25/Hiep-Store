<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerService
{
    public function get($params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? PER_PAGE;
        return Manager::orderBy('id', 'asc')->paginate($perPage);
    }

    public function findUserById(int $id)
    {
        return Manager::findOrFail($id);
    }

    public function update(int $id, array $userData): Manager
    {
        $user = $this->findUserById($id);

        $user->update($userData);

        return $user;
    }
}
