<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class DiscountUpdateRequest extends FormRequest
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
            'code' => 'required', 'string', 'max:32', 'unique:discounts,code' . $this->id,
            'value' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['required', 'numeric', 'min:0'],
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
            'quantity.required' => 'Vui lòng nhập số lượng discount',
            'quantity.numeric' => 'Số lượng phải là một số',
            'quantity.min' => 'Số lượng không được nhỏ hơn 0',
            'expiration_date.required' => 'Vui lòng nhập ngày hết hạn',
            'expiration_date.date' => 'Ngày hết hạn phải là một ngày hợp lệ',
            'expiration_date.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hiện tại'
        ];
    }
}
