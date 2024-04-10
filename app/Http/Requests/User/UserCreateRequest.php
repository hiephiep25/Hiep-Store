<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'email', 'unique:users,email'],
            'role' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của người dùng',
            'name.max' => 'Tên phải nhỏ hơn 255 kí tự',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự',
            'email.required' => 'Vui lòng nhập email',
            'email.unique' => 'Email đã tồn tại, hãy chọn email khác',
            'role.required' => 'Vui lòng nhập vai trò'
        ];
    }
}
