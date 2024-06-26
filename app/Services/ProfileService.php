<?php

namespace App\Services;

use App\Models\Manager;
use App\Models\Staff;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function profile()
    {
        $user = Auth::user();
        if ($user->role === User::ROLE_MANAGER) {
            $manager = User::with('manager')->find($user->id);
            return $manager;
        } elseif ($user->role === User::ROLE_SUPPLIER) {
            $supplier = User::with('supplier')->find($user->id);
            return $supplier;
        } elseif ($user->role === User::ROLE_STAFF) {
            $staff = User::with('staff')->find($user->id);
            return $staff;
        } else {
            return $user;
        }
    }

    public function updatePassword(string $password)
    {
        Auth::user()->update([
            'password' => Hash::make($password)
        ]);
    }

    public function updateProfile($userData, $supplierData)
    {
        $user = Auth::user();
        if (!empty($userData['avatar'])) {
            if ($user->avatar) {
                unlink($user->avatar);
            }

            $name = $userData['avatar']->getClientOriginalName();
            $directory = "public/avatars/{$user->id}";
            $path = Storage::putFileAs($directory, $userData['avatar'], $name);

            $userData['avatar'] = str_replace('public/', 'storage/', $path);
        }
        $user->update($userData);

        if ($user->role === User::ROLE_SUPPLIER) {
            Supplier::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $supplierData['company_name'],
                    'company_address' => $supplierData['company_address'],
                    'company_contact' => $supplierData['company_contact'],
                ]
            );
        }

        return $user;
    }
}
