<?php

namespace App\Http\Requests\EquipmentCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEquipmentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:equipment_categories,name,'.$id],
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
