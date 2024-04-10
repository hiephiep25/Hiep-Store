<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8']
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự trở lên',
            'password.confirmed' => 'Mật khẩu không trùng khớp với xác nhận mật khẩu.',
            'password_confirmation.required' => 'Xác nhận mật khẩu là trường bắt buộc.',
            'password_confirmation.string' => 'Xác nhận mật khẩu phải là một chuỗi.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự.'
        ];
    }
}
