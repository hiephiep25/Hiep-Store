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
        ];

        $rulesManager = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'store_name' => 'required|string|max:255',
            'store_address' => 'required|string',
            'store_contact' => 'required|string',
        ];

        $rulesSupplier = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_contact' => 'required|string',
        ];
        
        if($this->role === User::ROLE_ADMIN) {
            return $rules;
        } elseif($this->role === User::ROLE_MANAGER) {
            return $rulesManager;
        } else {
            return $rulesSupplier;
        }
    }
}
