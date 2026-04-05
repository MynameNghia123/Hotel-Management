<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Lấy ID từ route để dùng cho rule unique khi update
        $roleId = $this->route('role'); 

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