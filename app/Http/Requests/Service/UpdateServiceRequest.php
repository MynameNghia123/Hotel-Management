<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'group_id' => 'required|exists:service_groups,id',
            'unit_price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ không được bỏ trống.',
            'group_id.required' => 'Vui lòng chọn nhóm dịch vụ.',
            'group_id.exists' => 'Nhóm dịch vụ không hợp lệ.',
            'unit_price.required' => 'Đơn giá không được bỏ trống.',
            'unit_price.numeric' => 'Đơn giá phải là số.',
            'unit.required' => 'Đơn vị tính không được bỏ trống.',
        ];
    }
}
