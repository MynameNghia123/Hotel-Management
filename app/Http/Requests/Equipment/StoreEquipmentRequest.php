<?php

namespace App\Http\Requests\Equipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'equipment_category_id' => ['required', 'exists:equipment_categories,id'],
            'import_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên thiết bị.',
            'equipment_category_id.required' => 'Vui lòng chọn phân loại thiết bị.',
            'equipment_category_id.exists' => 'Phân loại thiết bị không hợp lệ.',
            'import_price.required' => 'Vui lòng nhập giá nhập.',
            'import_price.numeric' => 'Giá nhập phải là số.',
            'import_price.min' => 'Giá nhập không được âm.',
        ];
    }
}
