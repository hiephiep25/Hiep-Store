<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
            'name' => 'required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/', 'unique:categories,name'. $this->id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của category',
            'name.max' => 'Tên không được vượt quá 255 ký tự',
            'name.regex' => 'Tên chỉ có thể chứa ký tự chữ cái và khoảng trắng',
            'name.unique' => 'Tên đã tồn tại trong hệ thống',
        ];
    }
}
