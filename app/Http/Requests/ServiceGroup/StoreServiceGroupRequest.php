<?php

namespace App\Http\Requests\ServiceGroup;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'service_name.required' => 'Tên nhóm dịch vụ mưu cầu không được bỏ trống.',
            'service_name.string' => 'Tên nhóm dịch vụ phải là chuỗi ký tự.',
            'service_name.max' => 'Tên nhóm dịch vụ không được vượt quá 255 ký tự.',
        ];
    }
}
