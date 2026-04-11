<?php
namespace App\Http\Requests\RoleClaim;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoleClaimRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => 'required|exists:roles,id',
            'claim_name' => 'required|string|max:255',
            'claim_value' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'role_id.required' => 'Bạn phải chọn vai trò.',
            'role_id.exists' => 'Vai trò không tồn tại.',
            'claim_name.required' => 'Tên quyền là bắt buộc.',
            'claim_value.required' => 'Giá trị quyền là bắt buộc.',
        ];
    }
}