<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'email' => 'required|email|unique:staffs,email_personal,' . $this->id,
        ];

        $rulesManager = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'email' => 'required|email|unique:staffs,email_personal,' . $this->id,
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_contact' => 'required|string',
        ];

        $rulesSupplier = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'email' => 'required|email|unique:staffs,email_personal,' . $this->id,
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_contact' => 'required|string',
        ];

        $rulesStaff = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'email' => 'required|email|unique:staffs,email_personal,' . $this->id,
            'phone' => 'required|regex:/^[0-9]+$/|min:8|max:13',
            'address' => 'required|string',
            'dob' => 'required|date|before_or_equal:today',
        ];

        if($this->role === User::ROLE_ADMIN) {
            return $rules;
        } elseif($this->role === User::ROLE_MANAGER) {
            return $rulesManager;
        } elseif($this->role === User::ROLE_STAFF) {
            return $rulesStaff;
        } else {
            return $rulesSupplier;
        }
    }
}
