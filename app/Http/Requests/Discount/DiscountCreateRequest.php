<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class DiscountCreateRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:32', 'unique:discounts,code'],
            'value' => ['required', 'string', 'regex:/^\d+(\.\d{1,2})?$/'],
            'start_date' => ['required', 'date', 'after_or_equal:today' ],
            'expiration_date' => ['required', 'date', 'after_or_equal:today' ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của discount',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'code.required' => 'Vui lòng nhập mã code của discount',
            'code.max' => 'Mã code không được vượt quá 32 ký tự',
            'code.unique' => 'Mã code đã tồn tại trong hệ thống',
            'value.required' => 'Giá trị là trường bắt buộc',
            'value.regex' => 'Giá trị không hợp lệ',
            'start_date.required' => 'Vui lòng nhập ngày bắt đầu',
            'start_date.date' => 'Ngày bắt đầu phải là một ngày hợp lệ',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày hiện tại',
            'expiration_date.required' => 'Ngày hết hạn là trường bắt buộc',
            'expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ',
            'expiration_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hiện tại'
        ];
    }
}
