<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function get(array $params): LengthAwarePaginator
    {
        $name = $params['name'] ?? '';
        $email = $params['email'] ?? '';
        $perPage = $params['per_page'] ?? PER_PAGE;
        return User::where(function ($query) use ($name, $email) {
            if (!empty($name)) {
                $query->where('name', 'like', "%$name%");
            }
            if (!empty($email)) {
                $query->where('email', 'like', "%$email%");
            }
        })->orderBy('id', 'asc')->paginate($perPage);
    }

    public function create(array $data): User
    {
        $user = User::create([
            ...$data,
            'password' => Hash::make($data['password'])
        ]);

        if($user->role == User::ROLE_MANAGER) {
            Manager::create([
                'user_id' => $user->id,
                'store_id' => 0,
            ]);
        }
        if($user->role == User::ROLE_STAFF) {
            Staff::create([
                'user_id' => $user->id,
                'store_id' => 0,
            ]);
        }
        if($user->role == User::ROLE_SUPPLIER) {
            Supplier::create([
                'user_id' => $user->id,
                'company_name' => '-',
                'company_address' => '-',
                'company_contact' => '-',
            ]);
        }
        if($user->role == User::ROLE_CUSTOMER) {
            Customer::create([
                'user_id' => $user->id,
                'number_of_order' => '0',
            ]);
        }

        return $user;
    }

    public function findUserById(int $id)
    {
        return User::findOrFail($id);
    }

    public function update(int $id, array $userData): User
    {
        $user = $this->findUserById($id);
        if (isset($userData['password'])) {
            $userData['password'] = Hash::make($userData['password']);
        } else {
            $userData['password'] = $user->password;
        }
        $user->update($userData);

        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->findUserById($id);
        $user->delete();
    }
}
