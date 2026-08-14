<?php

namespace App\Http\Requests\EquipmentCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:equipment_categories,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên phân loại.',
            'name.unique' => 'Tên phân loại này đã tồn tại.',
            'name.max' => 'Tên phân loại không được quá 255 ký tự.',
        ];
    }
}
