<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function updatePassword(PasswordRequest $request)
    {
        $this->profileService->updatePassword($request->password);
        return $this->success();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->hasFile('avatar') ? $request->only(['name', 'avatar']) : $request->only(['name']);
        $this->profileService->updateProfile($user);
        return $this->success();
    }
}
