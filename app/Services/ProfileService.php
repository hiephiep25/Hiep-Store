<?php

namespace App\Services;

use App\Models\Manager;
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

    public function updateProfile($userData, $managerData, $supplierData)
    {
        $user = Auth::user();
        if (!empty($userData['avatar'])) {
            if ($user->avatar) {
                $avatarPath = public_path($user->avatar);
                if (file_exists($avatarPath)) {
                    unlink($avatarPath);
                }
            }
            $name = $userData['avatar']->getClientOriginalName();
            $userData['avatar'] = url(Storage::url(Storage::putFileAs("/public/avatars/{$user->id}", $userData['avatar'], $name)));
        }
        $user->update($userData);

        if($user->role === User::ROLE_MANAGER){
            Manager::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'store_name' => $managerData['store_name'],
                    'store_address' => $managerData['store_address'],
                    'store_contact' => $managerData['store_contact'],
                ]
            );
        }

        if($user->role === User::ROLE_SUPPLIER){
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
