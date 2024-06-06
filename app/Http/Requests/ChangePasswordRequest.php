<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'token' => 'required|string',
            'password' => 'required|string|min:6|max:20',
            'password_confirm' => 'required|string|same:password',
        ];
    }
    public function messages()
    {
        return [
            'token.required' => 'Mã token là bắt buộc.',
            'token.string' => 'Mã token phải là một chuỗi.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.string' => 'Mật khẩu phải là một chuỗi.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá :max ký tự.',
            'password_confirm.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'password_confirm.string' => 'Xác nhận mật khẩu phải là một chuỗi.',
            'password_confirm.same' => 'Xác nhận mật khẩu không khớp với mật khẩu.',
        ];
    }
}
