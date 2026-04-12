<?php

namespace App\Http\Requests\Customer;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('id');

        return [
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'phone_number' => 'required|string|max:20|unique:customers,phone_number,' . $customerId,
            'email'        => 'nullable|email|max:100|unique:customers,email,' . $customerId,
            'country'      => 'nullable|string|max:100',
      ];
    }
}
