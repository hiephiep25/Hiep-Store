<?php

namespace App\Services;

use App\Models\User;
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
