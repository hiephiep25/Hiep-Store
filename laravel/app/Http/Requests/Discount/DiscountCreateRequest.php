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
            'start' => ['required', 'date', 'after_or_equal:today' ],
            'end' => ['required', 'date', 'after_or_equal:today' ],
            'image' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
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
            'start.required' => 'Vui lòng nhập ngày bắt đầu',
            'start.date' => 'Ngày bắt đầu phải là một ngày hợp lệ',
            'start.after_or_equal' => 'Ngày bắt đầu phải sau hoặc bằng ngày hiện tại',
            'end.required' => 'Ngày hết hạn là trường bắt buộc',
            'end.date' => 'Ngày hết hạn phải là một ngày hợp lệ',
            'end.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hiện tại',
            'image.required' => 'Vui lòng chọn một hình ảnh cho discount.',
            'image.file' => 'File phải là hình ảnh.',
            'image.mimes' => 'File ảnh phải có định dạng: jpeg, jpg, png hoặc gif.',
            'image.max' => 'Kích thước file ảnh không được vượt quá :max KB.',
        ];
    }
}
