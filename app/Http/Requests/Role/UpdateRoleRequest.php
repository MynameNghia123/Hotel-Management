<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Lấy role ID từ route parameter
        $roleId = $this->route('id');

        return [
            'role_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('roles', 'name')->ignore($roleId),
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
            'role_name.max' => 'Tên vai trò không được vượt quá 100 ký tự.',
        ];
    }

    /**
     * Transform data trước khi đẩy vào Service
     * Chuyển role_name thành name để match với database column
     */
    public function mapped(): array
    {
        return [
            'name' => $this->role_name,
            'permissions' => $this->permissions ?? [],
        ];
    }
}
