<?php

namespace App\Http\Requests\RoomMap;

use Illuminate\Foundation\Http\FormRequest;

class AddCheckoutServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'integer', 'min:1'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Dịch vụ là bắt buộc.',
            'service_id.integer' => 'Dịch vụ phải là số nguyên.',
            'service_id.min' => 'Dịch vụ phải lớn hơn 0.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
        ];
    }
}
