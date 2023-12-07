<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function updatePassword(string $password)
    {
        Auth::user()->update([
            'password' => Hash::make($password)
        ]);
    }

    public function updateProfile($userData)
    {
        $user = Auth::user();
    }
}
