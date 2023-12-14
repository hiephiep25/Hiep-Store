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
            'image' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
            'license_company' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
            'license_product' => ['required', 'file', 'mimes:jpeg,jpg,png,gif', 'max:100000'],
        ];
    }
}
