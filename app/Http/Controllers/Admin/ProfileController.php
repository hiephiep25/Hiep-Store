<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileController extends Controller
{
    public $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function profile()
    {
        return new JsonResource($this->profileService->profile());
    }

    public function updatePassword(PasswordRequest $request)
    {
        $this->profileService->updatePassword($request->password);
        return $this->success();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $userData = $request->hasFile('avatar') ? $request->only(['name', 'email', 'avatar']) : $request->only(['name', 'email']);
        $managerData = $request->only(['store_name', 'store_address', 'store_contact']);
        $supplierData = $request->only(['company_name', 'company_address', 'company_contact']);
        $staffData = $request->only(['phone', 'address', 'dob']);
        $this->profileService->updateProfile($userData, $managerData, $supplierData, $staffData);
        return $this->success();
    }
}
