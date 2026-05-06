<?php

namespace App\Http\Requests\Staff;

use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    public function rules(): array
    {
        $staffId = $this->route('id');
        
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('staff', 'email')->ignore($staffId),
            ],
            'phone_number' => 'required|string|max:20',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Họ là bắt buộc',
            'last_name.required' => 'Tên là bắt buộc',
            'role_id.required' => 'Vai trò là bắt buộc',
            'role_id.exists' => 'Vai trò không tồn tại',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'phone_number.required' => 'Số điện thoại là bắt buộc',
        ];
    }

    /**
     * Xóa password trước khi validation nếu nó trống (giữ mật khẩu cũ)
     */
    protected function prepareForValidation()
    {
        if (empty($this->password)) {
            $this->request->remove('password');
            $this->request->remove('password_confirmation');
        }

        $staff = Staff::find($this->route('id'));
        $email = trim((string) $this->input('email', ''));

        if ($this->has('email') && $staff && ($email === '' || $email === (string) $staff->email)) {
            $this->request->remove('email');
        } elseif ($this->has('email')) {
            $this->merge(['email' => $email]);
        }
    }

    /**
     * Override validated() để đảm bảo password không được gửi lên service
     */
    public function validated($key = null, $default = null)
    {
        $data = parent::validated($key, $default);
        
        // Xóa password_confirmation khỏi dữ liệu trước khi return
        unset($data['password_confirmation']);
        
        return $data;
    }
}
