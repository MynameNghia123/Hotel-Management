<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'phone_number' => 'required|string|max:20|unique:customers,phone_number',
            'email'        => 'nullable|email|max:100|unique:customers,email',
            'country'      => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'   => 'Vui lòng nhập họ.',
            'last_name.required'    => 'Vui lòng nhập tên.',
            'phone_number.required' => 'Số điện thoại không được để trống.',
            'phone_number.unique'   => 'Số điện thoại này đã tồn tại.',
            'email.email'           => 'Địa chỉ email không đúng định dạng.',
            'email.unique'          => 'Email này đã tồn tại.',
        ];
    }
}
