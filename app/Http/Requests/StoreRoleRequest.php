<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100|unique:roles,name',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Bạn phải nhập tên vai trò.',
            'name.unique' => 'Tên vai trò đã tồn tại.',
        ];
    }
}