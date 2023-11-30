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
            'quantity' => ['required', 'numeric', 'min:0'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today' ],
        ];
    }
}
