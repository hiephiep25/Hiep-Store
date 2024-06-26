<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ProductCreateRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:32', 'unique:products,code'],
            'brand' => ['nullable', 'string', 'max:255'],
            'qty' => ['required', 'numeric', 'min:0'],
            'price_per_qty' => ['required', 'numeric', 'min:0'],
            'manufacture_day' => ['nullable', 'date', 'before:expiry_day'],
            'expiry_day' => ['nullable', 'date', 'after_or_equal:today' ],
            'image' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.string' => 'Tên sản phẩm phải là chuỗi.',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'code.required' => 'Vui lòng nhập mã sản phẩm.',
            'code.string' => 'Mã sản phẩm phải là chuỗi.',
            'code.max' => 'Mã sản phẩm không được vượt quá :max ký tự.',
            'code.unique' => 'Mã sản phẩm đã tồn tại trong hệ thống, vui lòng chọn mã khác.',
            'brand.string' => 'Thương hiệu phải là chuỗi.',
            'brand.max' => 'Thương hiệu không được vượt quá :max ký tự.',
            'qty.required' => 'Vui lòng nhập số lượng sản phẩm.',
            'qty.numeric' => 'Số lượng sản phẩm phải là số.',
            'qty.min' => 'Số lượng sản phẩm phải lớn hơn hoặc bằng 0.',
            'price_per_qty.required' => 'Vui lòng nhập giá sản phẩm.',
            'price_per_qty.numeric' => 'Giá sản phẩm phải là số.',
            'price_per_qty.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'manufacture_day.date' => 'Ngày sản xuất phải là ngày hợp lệ.',
            'manufacture_day.before' => 'Ngày sản xuất phải trước ngày hết hạn.',
            'expiry_day.date' => 'Ngày hết hạn phải là ngày hợp lệ.',
            'expiry_day.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày hiện tại.',
            'image.required' => 'Vui lòng chọn một hình ảnh cho sản phẩm.',
            'image.file' => 'File phải là hình ảnh.',
            'image.mimes' => 'File ảnh phải có định dạng: jpeg, jpg, png hoặc gif.',
            'image.max' => 'Kích thước file ảnh không được vượt quá :max KB.',
        ];
    }
}
