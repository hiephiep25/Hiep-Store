<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'code' => 'required', 'string', 'max:32', 'unique:products,code' . $this->id,
            'brand' => ['nullable', 'string', 'max:255'],
            'qty' => ['required', 'numeric', 'min:0'],
            'price_per_qty' => ['required', 'numeric', 'min:0'],
            'manufacture_day' => ['nullable', 'date', 'before:expiry_day'],
            'expiry_day' => ['nullable', 'date'],
            'image' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
        ];
    }
}
