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
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|regex:/^[0-9]+$/|min:8|max:13',
            'address' => 'required|string',
            'dob' => 'required|date|before_or_equal:today',
        ];

        $rulesSupplier = [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:100000',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'nullable|regex:/^[0-9]+$/|min:8|max:13',
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'dob' => 'required|date|before_or_equal:today',
            'company_address' => 'required|string',
            'company_contact' => 'required|string',
        ];

        if($this->role === User::ROLE_SUPPLIER) {
            return $rulesSupplier;
        } else {
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'name.max' => 'Tên phải nhỏ hơn 255 kí tự',
            'email.unique' => 'Email đã tồn tại, hãy chọn email khác',
            'company_name.required' => 'Tên công ty không được bỏ trống',
            'company_address.required' => 'Địa chỉ công ty không được bỏ trống',
            'company_contact.required' => 'Liên hệ công ty không được bỏ trống',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'dob.date' => 'Định dạng ngày không hợp lệ',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'dob.before_or_equal' => 'Ngày sinh không hợp lệ',
            'address.required' => 'Địa chỉ không được bỏ trống',
            'dob.required' => 'Ngày sinh không được bỏ trống'
        ];
    }
}
