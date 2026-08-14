<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role_name' => [
                'required',
                'string',
                'max:100',
                'unique:roles,name',  // Không cần ignore khi tạo mới
            ],
            'permissions' => 'sometimes|array',
            'permissions.*' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'role_name.required' => 'Bạn phải nhập tên vai trò.',
            'role_name.unique' => 'Tên vai trò này đã tồn tại rồi.',
        ];
    }

    /**
     * Hàm này giúp "chuẩn hóa" dữ liệu trước khi đẩy vào Service
     */
    public function mapped(): array
    {
        return [
            'name' => $this->role_name,
            'permissions' => $this->permissions ?? [],
        ];
    }
}
