<?php

namespace App\Http\Requests\Staff;
use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|email|unique:staff,email',
            'phone_number' => 'required|string|max:20',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'Vui lòng chọn vai trò.',
            'role_id.exists' => 'Vai trò không tồn tại.',
            'first_name.required' => 'Họ là bắt buộc.',
            'last_name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'phone_number.required' => 'Số điện thoại là bắt buộc.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}