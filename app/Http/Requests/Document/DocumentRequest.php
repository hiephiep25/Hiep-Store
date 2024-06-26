<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class DocumentRequest extends FormRequest
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
            'product_name' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'manufacture_day' => ['nullable', 'date', 'before:expiry_day'],
            'expiry_day' => ['nullable', 'date', 'after_or_equal:today' ],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
            'license_company' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
            'license_product' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
        ];
    }
    public function messages(): array
    {
        return [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'qty.required' => 'Số lượng là bắt buộc.',
            'price.required' => 'Giá là bắt buộc.',
            'manufacture_day.before' => 'Ngày sản xuất phải trước ngày hết hạn.',
            'expiry_day.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hôm nay.',
            'image.required' => 'Ảnh sản phẩm là bắt buộc.',
            'license_company.required' => 'Giấy phép của công ty là bắt buộc.',
            'license_product.required' => 'Giấy phép sản phẩm là bắt buộc.',
            '*.file' => 'Trường này phải là một tệp tin.',
            '*.mimes' => 'Tệp tin phải có định dạng jpeg, jpg, png hoặc gif.',
            '*.max' => 'Kích thước tệp tin không được vượt quá :max kilobytes.',
            '*.date' => 'Trường này phải là một ngày.',
            '*.numeric' => 'Trường này phải là một số.',
            '*.min' => 'Giá trị của trường này không được nhỏ hơn :min.',
        ];
    }
}
