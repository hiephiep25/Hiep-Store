<?php

namespace App\Services;

use App\Models\User;
use App\Models\Staff;
use App\Models\Manager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffService
{
    public function get($params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? PER_PAGE;
        if(auth()->user()->role == User::ROLE_ADMIN) {
            return Staff::orderBy('id', 'asc')->paginate($perPage);
        }
        if(auth()->user()->role == User::ROLE_MANAGER) {
            $storeId = Manager::where('user_id', auth()->id())->firstOrFail()->store_id;
            return Staff::where('store_id', $storeId)->orderBy('id', 'asc')->paginate($perPage);
        }
    }

    public function findUserById(int $id)
    {
        return Staff::findOrFail($id);
    }

    public function update(int $id, array $userData): Staff
    {
        $user = $this->findUserById($id);

        $user->update($userData);

        return $user;
    }
}
