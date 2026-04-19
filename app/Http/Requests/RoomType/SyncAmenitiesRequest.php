<?php

namespace App\Http\Requests\RoomType;

use Illuminate\Foundation\Http\FormRequest;

class SyncAmenitiesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'amenity_ids' => 'nullable|array',
            'amenity_ids.*' => 'integer|exists:amenities,id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amenity_ids.array' => 'Danh sách tiện ích phải là một mảng.',
            'amenity_ids.*.integer' => 'ID tiện ích phải là một số nguyên.',
            'amenity_ids.*.exists' => 'ID tiện ích không tồn tại.'
        ];
    }
}
